<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;

use App\Page;
use App\News;
use App\Mode;
use App\Slide;
use App\Product;
use App\Comment;
use App\Company;
use App\Category;

class PageController extends Controller
{
    public function index()
    {
        $news = News::where('status', 1)->orderBy('created_at', 'desc')->take(6)->get();
        $modes = Mode::whereIn('slug', ['new', 'top', 'budgetary'])->get();
        $slide_mode = Mode::where('slug', 'slide')->first();
        $slide_items = Slide::where('status', 1)->take(10)->get();
        $categories_part = Category::whereIn('slug', ['gadjets', 'life-style'])->orderBy('sort_id')->get();

        $ids = collect();

        foreach ($categories_part as $key => $category_item)
        {
            if ($category_item->children && count($category_item->children) > 0) {
                $ids[$key] = $category_item->children->pluck('id');
            }
        }

        $products_part = Product::where('status', 1)->whereIn('category_id', $ids[0])->orderBy('sort_id')->take(16)->get();
        $products_part2 = Product::where('status', 1)->whereIn('category_id', $ids[1])->orderBy('sort_id')->take(16)->get();
        $group_products = [0 => $products_part, 1 => $products_part2];

        return view('pages.index', compact('news', 'modes', 'slide_mode', 'slide_items', 'categories_part', 'group_products'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.page')->with('page', $page);
    }

    public function allCategoryProducts(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        $categories = $category->descendants()->pluck('id');

        // Include the id of category itself
        $categories[] = $category->getKey();

        // Action operations
        $actions = ['default' => 'id', 'low' => 'price', 'expensive' => 'price DESC', 'popular' => 'views DESC'];
        $sort = ($request->session()->has('action')) ? $actions[session('action')] : 'id';

        if ($request->ajax() AND isset($request->action)) {
            $request->session()->put('action', $request->action);
        }

        // Option operations
        if ($request->ajax() AND isset($request->options_id)) {
            $request->session()->put('options', $request->options_id);
        }

        if ($request->ajax() AND empty($request->action) AND empty($request->options_id)) {
            $request->session()->forget('options');
        }

        if ($request->session()->has('options')) {
    
            $options_id = session('options');
            $products = Product::where('status', '<>', 0)->whereIn('category_id', $categories)->orderByRaw($sort)
                ->whereHas('options', function ($query) use ($options_id) {
                    $query->whereIn('option_id', $options_id);
                })->paginate(12);
        }
        else {
            $products = Product::where('status', '<>', 0)->whereIn('category_id', $categories)->orderByRaw($sort)
                ->paginate(12);
        }

        if ($request->ajax()) {
            return response()->json(view('pages.products-render', ['products' => $products])->render());
        }

        $options = DB::table('products')
            ->join('product_option', 'products.id', '=', 'product_option.product_id')
            ->join('options', 'options.id', '=', 'product_option.option_id')
            ->select('options.id', 'options.slug', 'options.title', 'options.data')
            ->whereIn('category_id', $categories)
            // ->where('products.status', '<>', 0)
            ->distinct()
            ->get();

        $grouped = $options->groupBy('data');

        return view('pages.products')->with(['category' => $category, 'products' => $products, 'grouped' => $grouped]);
    }

    public function categoryProducts(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        // Action operations
        $actions = ['default' => 'id', 'low' => 'price', 'expensive' => 'price DESC', 'popular' => 'views DESC'];
        $sort = ($request->session()->has('action')) ? $actions[session('action')] : 'id';

        if ($request->ajax() AND isset($request->action)) {
            $request->session()->put('action', $request->action);
        }

        // Option operations
        if ($request->ajax() AND isset($request->options_id)) {
            $request->session()->put('options', $request->options_id);
        }

        if ($request->ajax() AND empty($request->action) AND empty($request->options_id)) {
            $request->session()->forget('options');
        }

        if ($request->session()->has('options')) {

            $options_id = session('options');

            $products = Product::where('status', '<>', 0)->where('category_id', $category->id)->orderByRaw($sort)
                ->whereHas('options', function ($query) use ($options_id) {
                    $query->whereIn('option_id', $options_id);
                })->paginate(12);
        }
        else {
            $products = Product::where('status', '<>', 0)->where('category_id', $category->id)->orderByRaw($sort)
                ->paginate(12);
        }

        if ($request->ajax()) {
            return response()->json(view('pages.products-render', ['products' => $products])->render());
        }

        $options = DB::table('products')
            ->join('product_option', 'products.id', '=', 'product_option.product_id')
            ->join('options', 'options.id', '=', 'product_option.option_id')
            ->select('options.id', 'options.slug', 'options.title', 'options.data')
            ->where('category_id', $category->id)
            // ->where('products.status', '<>', 0)
            ->distinct()
            ->get();

        $grouped = $options->groupBy('data');

        return view('pages.products')->with(['category' => $category, 'products' => $products, 'grouped' => $grouped]);
    }

    public function brandProducts($company_slug)
    {
        $page = Page::where('slug', 'catalog')->firstOrFail();
        $company = Company::where('slug', $company_slug)->first();

        return view('pages.products')->with(['page' => $page, 'products_title' => $page->title, 'products' => $company->products]);
    }

    public function product($product_id, $product_slug)
    {
        $product = Product::where('id', $product_id)->firstOrFail();
        $category = Category::where('id', $product->category_id)->firstOrFail();
        $products = Product::search($product->title)->where('status', 1)->take(4)->get();

        $product->views = $product->views + 1;
        $product->save();

        return view('pages.product')->with(['product' => $product, 'recent_products' => $products]);
    }

    public function saveComment(Request $request)
    {
        $this->validate($request, [
            'stars' => 'required|integer|between:1,5',
            'comment' => 'required|min:5|max:500',
        ]);


        $url = explode('/', URL::previous());
        $uri = explode('-', end($url));

        if ($request->id == $uri[0]) {
            $comment = new Comment;
            $comment->parent_id = $request->id;
            $comment->parent_type = 'App\Product';
            $comment->name = \Auth::user()->name;
            $comment->email = \Auth::user()->email;
            $comment->comment = $request->comment;
            $comment->stars = (int) $request->stars;
            $comment->save();
        }

        if ($comment) {
            return redirect()->back()->with('status', 'Отзыв добавлен!');
        }
        else {
            return redirect()->back()->with('status', 'Ошибка!');
        }
    }

    public function contacts()
    {
        $page = Page::where('slug', 'kontakty')->firstOrFail();

        return view('pages.contacts')->with('page', $page);
    }
}
