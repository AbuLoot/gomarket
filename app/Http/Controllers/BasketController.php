<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Country;
use App\Order;

use Auth;
use Mail;

class BasketController extends Controller
{
    public function clearBasket(Request $request)
    {
        $request->session()->forget('items');

        return redirect('/');
    }

    public function addToBasket(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->session()->has('items')) {

            $items = $request->session()->get('items');

            $items['products_id'][$id] = [
                'id' => $id, 'slug' => $product->slug, 'title' => $product->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
            ];

            $count = count($items['products_id']);

            $request->session()->put('items', $items);

            return response()->json([
                'alert' => 'Товар обновлен', 'countItems' => $count, 'slug' => $product->slug, 'title' => $product->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
            ]);
        }

        $items = [];
        $items['products_id'][$id] = [
            'id' => $id, 'slug' => $product->slug, 'title' => $product->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
        ];

        $request->session()->put('items', $items);

        return response()->json([
            'alert' => 'Товар обновлен', 'countItems' => 1, 'slug' => $product->slug, 'title' => $product->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
        ]);
    }

    public function removeFromBasket(Request $request, $id)
    {
        $items = $request->session()->get('items');
        $count = count($items['products_id']);

        if ($count == 1) {
            $count = 0;
            $request->session()->forget('items');
        }
        else {
            unset($items['products_id'][$id]);
            $count = $count - 1;
            $request->session()->put('items', $items);
        }

        return response()->json(['countItems' => $count]);
    }

    public function basket(Request $request)
    {
        $countries = Country::all();

        if ($request->session()->has('items')) {

            $items = $request->session()->get('items');
            $data_id = collect($items['products_id']);
            $products = Product::whereIn('id', $data_id->keys())->get();
        }
        else {
            $products = collect();
        }

        return view('pages.basket', compact('products', 'countries'));
    }

    public function order(Request $request)
    {
        $countries = Country::all();

        if ($request->session()->has('items')) {

            $items = $request->session()->get('items');
            $data_id = collect($items['products_id']);
            $products = Product::whereIn('id', $data_id->keys())->get();
        }

        return view('pages.order', compact('products', 'countries'));
    }

    public function storeOrder(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|min:5',
            'city_id' => 'numeric',
            'address' => 'required',
        ]);

        $items = $request->session()->get('items');
        $data_id = collect($items['products_id']);
        $products = Product::whereIn('id', $data_id->keys())->get();

        $sumCountProducts = 0;
        $sumPriceProducts = 0;

        foreach ($products as $product) {
            $sumCountProducts += $request->count[$product->id];
            $sumPriceProducts += $request->count[$product->id] * $product->price;
        }

        $order = new Order;
        $order->user_id = ((Auth::check())) ? Auth::id() : 0;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->company_name = '';
        $order->data_1 = '';
        $order->data_2 = '';
        $order->data_3 = '';
        $order->legal_address = '';
        $order->address = $request->address;
        $order->city_id = ($request->city_id) ? $request->city_id : 0;
        $order->delivery = trans('orders.get.'.$request->get);
        $order->payment_type = trans('orders.pay.'.$request->pay);
        $order->count = serialize($request->count);
        $order->price = $products->sum('price');
        $order->amount = $sumPriceProducts;
        $order->save();

        $order->products()->attach($data_id->keys());

        $name = $request->name;

        try {

            Mail::send('vendor.mail.html.layout', ['order' => $order], function($message) use ($name) {
                $message->to('issayev.adilet@gmail.com', 'GoMarket')->subject('GoMarket - Новый заказ от '.$name);
                $message->from('electron.servant@gmail.com', 'Electron Servant');
            });

            $status = 'alert-success';
            $message = 'Ваш заказ принят!';

        } catch (Exception $e) {

            $status = 'alert-danger';
            $message = 'Произошла ошибка: '.$e->getMessage();
        }

        $request->session()->forget('items');

        return redirect('/')->with('status', $message);
    }

    public function destroy(Request $request, $id)
    {
        $items = $request->session()->get('items');

        if (count($items['products_id']) == 1) {
            $request->session()->forget('items');
        }
        else {
            unset($items['products_id'][$id]);
            $request->session()->put('items', $items);
        }

        return redirect('basket');
    }
}