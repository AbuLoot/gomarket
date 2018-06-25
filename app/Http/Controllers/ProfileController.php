<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;
use App\City;
use App\Order;
use App\Http\Requests;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        return view('pages.profile', compact('user'));
    }

    public function myOrders()
    {
        $user = Auth::user();
        $orders = $user->orders()->paginate(10);

        return view('pages.orders', compact('user', 'orders'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $cities = City::orderBy('sort_id')->get();

        // $date = [];
        // list($date['year'], $date['month'], $date['day']) = explode('-', $user->profile->birthday);

        return view('pages.profile-edit', compact('user', 'cities'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            'email' => 'required|email|max:255',
            'city_id' => 'required|numeric',
            'sex' => 'required'
        ]);

        $user = Auth::user();

        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->profile->phone = $request->phone;
        $user->profile->city_id = $request->city_id;
        $user->profile->about = $request->about;
        $user->profile->sex = $request->sex;
        $user->profile->save();

        return redirect('/my-profile')->with('status', 'Запись обновлена!');
    }
}
