<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use Storage;

use App\Page;
use App\Mode;
use App\Option;
use App\Product;
use App\Company;
use App\Category;

class PageController extends Controller
{
    public function index()
    {
        $modes = Mode::whereIn('slug', ['new', 'top', 'budgetary'])->get();
        $slide_mode = Mode::where('slug', 'slide')->first();
        $trend_mode = Mode::where('slug', 'trend')->first();
        $categories_part = Category::whereIn('slug', ['gadjets', 'life-style'])->orderBy('sort_id')->get();

        $ids = collect();

        foreach ($categories_part as $key => $category_item) {

            if ($category_item->children && count($category_item->children) > 0) {

                $ids[$key] = $category_item->children->pluck('id');
            }
        }

        $group_ids = $ids->collapse();

        // $viewed = session('viewed');
        // $products_viewed = Product::where('status', 1)->whereIn('id', $viewed['products_id'])->orderBy('sort_id')->take(18)->get();
        $products_part = Product::where('status', 1)->whereIn('category_id', $ids[0])->orderBy('sort_id')->take(16)->get();
        $products_part2 = Product::where('status', 1)->whereIn('category_id', $ids[1])->orderBy('sort_id')->take(16)->get();

        $group_products = [0 => $products_part, 1 => $products_part2];

        return view('pages.index', compact('modes', 'slide_mode', 'trend_mode', 'categories_part', 'group_products'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.page')->with('page', $page);
    }

    public function categoryProducts(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        if (isset($request->options_id) AND !empty($request->options_id) and !isset($request->price_from)) {

            list($keys, $options_id) = array_divide($request->options_id);

            $products = Product::where('status', 1)->where('category_id', $category->id)
                ->whereHas('options', function ($query) use ($options_id) {
                    $query->whereIn('option_id', $options_id);
                })->paginate(12);

            $products->appends([
                'options_id' => $options_id
            ]);

            return response()->json(view('pages.products-render', ['products' => $products])->render());
        }
        /*else if (isset($request->options_id) AND !empty($request->options_id) AND isset($request->price_from, $request->price_to)) {

            $price_from = ($request->price_from) ? (int) $request->price_from : 0;
            $price_to = ($request->price_to) ? (int) $request->price_to : 9999999999;

            $products = Product::where('status', 1)->where('category_id', $category->id)->whereBetween('price', [$price_from, $price_to])->paginate(12);

            $options = DB::table('products')
                ->join('product_option', 'products.id', '=', 'product_option.product_id')
                ->join('options', 'options.id', '=', 'product_option.option_id')
                ->select('options.id', 'options.slug', 'options.title')
                ->where('category_id', $category->id)
                ->where('status', 1)
                ->distinct()
                ->get();

            $products->appends([
                // 'options' => $options,
                'price_from' => $price_from,
                'price_to' => $price_to
            ]);

            $grouped = $options->groupBy('data');

            return view('pages.products')->with(['category' => $category, 'products' => $products, 'grouped' => $grouped, 'price_from' => $price_from, 'price_to' => $price_to]);
        }*/
        else if ($request->ajax()) {
            $products = Product::where('status', 1)->where('category_id', $category->id)->paginate(12);
            return response()->json(view('pages.products-render', ['products' => $products])->render());
        }
        else {
            $products = Product::where('status', 1)->where('category_id', $category->id)->paginate(12);
        }

        $options = DB::table('products')
            ->join('product_option', 'products.id', '=', 'product_option.product_id')
            ->join('options', 'options.id', '=', 'product_option.option_id')
            ->select('options.id', 'options.slug', 'options.title', 'options.data')
            ->where('category_id', $category->id)
            ->where('status', 1)
            ->distinct()
            ->get();

        $grouped = $options->groupBy('data');

        if ($request->ajax()) {
            return response()->json(view('pages.products-render', ['products' => $products])->render());
        }

        return view('pages.products')->with(['category' => $category, 'result' => $request->options_id, 'products' => $products, 'options' => $options, 'grouped' => $grouped]);
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
        $products = Product::search($product->title)->take(4)->get();

/*        if (Session::has('viewed')) {

            $viewed = Session::get('viewed');
            $viewed['products_id'][$product->id] = $product->id;

            Session::set('viewed', $viewed);
        }
        else {

            $viewed = [];
            $viewed['products_id'][$product->id] = $product->id;

            Session::set('viewed', $viewed);
        }
*/
        return view('pages.product')->with(['product' => $product, 'recent_products' => $products]);
    }

    public function catalogs()
    {
        $page = Page::where('slug', 'katalog-zapchastey')->firstOrFail();

        $files = Storage::files('catalogs');

        return view('pages.parts-catalogs')->with(['page' => $page, 'files' => $files]);
    }

    public function contacts()
    {
        $page = Page::where('slug', 'kontakty')->firstOrFail();

        return view('pages.contacts')->with('page', $page);
    }
}
