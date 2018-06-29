<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;

use DB;
use Image;
use Storage;
use Validator;

use App\Http\Controllers\Controller;
use App\ImageTrait;
use App\Category;
use App\Company;
use App\Product;
use App\Option;
use App\Mode;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::orderBy('updated_at','desc')->paginate(50);
        $categories = Category::get()->toTree();
        $modes = Mode::all();

        return view('joystick-admin.products.index', ['categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function search(Request $request)
    {
        $text = trim(strip_tags($request->text));

        $products = Product::search($text)->paginate(50);

        $products->appends([
            'text' => $request->text,
        ]);

        return view('joystick-admin.products.found', compact('text', 'products'));
    }

    public function priceForm()
    {
        $categories = Category::get()->toTree();

        return view('joystick-admin.products.price-edit', ['categories' => $categories]);
    }

    public function categoryProducts($id)
    {
        $category = Category::find($id);
        $categories = Category::get()->toTree();
        $products = Product::where('category_id', $category->id)->orderBy('created_at')->paginate(50);
        $modes = Mode::all();

        return view('joystick-admin.products.index', ['category' => $category, 'categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function priceUpdate(Request $request)
    {
        $operations = [
            1 => '*',
            2 => '/',
            3 => '+',
            4 => '-'
        ];

        $category = Category::find($request->category_id);

        $ids[] = $category->id;

        if ($category->children && count($category->children) > 0) {
            $ids[] = $category->children->pluck('id');
        }

        $sql = 'UPDATE products SET price = (price ' . $operations[$request->operation] . ' ' . $request->number . ') WHERE category_id = ' . $request->category_id;

        DB::update($sql);

        return redirect('admin/products')->with('status', 'Цена изменена!');
    }

    public function actionProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        if (in_array($request->action, ['active', 'inactive'])) {

            switch ($request->action)
            {
                case 'active':
                    Product::whereIn('id', $request->products_id)->update(['status' => 1]);
                    break;

                case 'inactive':
                    Product::whereIn('id', $request->products_id)->update(['status' => 0]);
                    break;
            }
        }
        else {
            $mode = Mode::where('slug', $request->action)->first();
            $products = Product::whereIn('id', $request->products_id)->get();

            foreach ($products as $product) {
                $product->modes()->toggle($mode->id);
            }
        }

        return response()->json(['status' => true]);
    }

    public function create()
    {
        $categories = Category::get()->toTree();
        $companies = Company::get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        return view('joystick-admin.products.create', ['modes' => $modes, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:products',
            'category_id' => 'required|numeric',
            // 'images' => 'mimes:jpeg,jpg,png,svg,svgs,bmp,gif',
        ]);

        $category = Category::findOrFail($request->category_id);
        $introImage = null;
        $images = [];

        $dirName = $category->id.'/'.time();

        if ( ! file_exists('img/products/'.$category->id)) {
            Storage::makeDirectory('/img/products/'.$dirName);
        }

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.uniqid().'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

                    // Creating preview image
                    if ($key == 0) {
                        $this->resizeImage($image, 200, 200, '/img/products/'.$dirName.'/preview-'.$imageName, 100);
                        $introImage = 'preview-'.$imageName;
                    }

                    // $watermark = Image::make('img/watermark.png');
                    $color = 'rgba(0, 0, 0, 0)';

                    // Storing original images
                    // $image->storeAs('/img/products/'.$dirName, $imageName);
                    $this->resizeImage($image, 1024, 768, '/img/products/'.$dirName.'/'.$imageName, 90, null, $color);

                    // Creating present images
                    $this->resizeImage($image, 250, 250, '/img/products/'.$dirName.'/present-'.$imageName, 100);

                    // Creating mini images
                    $this->resizeImage($image, 100, 100, '/img/products/'.$dirName.'/mini-'.$imageName, 100);

                    $images[$key]['image'] = $imageName;
                    $images[$key]['present_image'] = 'present-'.$imageName;
                    $images[$key]['mini_image'] = 'mini-'.$imageName;
                }
            }
        }

        $product = new Product;
        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->category_id = $request->category_id;
        $product->slug = str_slug($request->title);
        $product->title = $request->title;
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->days = $request->days;
        $product->count = $request->count;
        $product->condition = $request->condition;
        $product->presense = $request->presense;
        $product->meta_description = $request->meta_description;
        $product->description = $request->description;
        $product->characteristic = $request->characteristic;
        $product->image = $introImage;
        $product->images = serialize($images);
        $product->path = $dirName;
        $product->lang = $request->lang;
        $product->mode = $request->mode;
        $product->status = ($request->status == 'on') ? 1 : 0;
        $product->save();

        if ( ! is_null($request->modes_id)) {
            $product->modes()->attach($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->attach($request->options_id);
        }

        return redirect('admin/products')->with('status', 'Товар добавлен!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get()->toTree();
        $companies = Company::get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        return view('joystick-admin.products.edit', ['modes' => $modes, 'product' => $product, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
            'category_id' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        $images = unserialize($product->images);

        if ($request->hasFile('images')) {

            $introImage = null;

            if ( ! file_exists('img/products/'.$product->category->id)) {
                $product->path = $product->category->id.'/'.time();
                Storage::makeDirectory('img/products/'.$product->path);
            }

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.uniqid().'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

                    // Creating preview image
                    if ($key == 0) {

                        if ($product->image != NULL AND $product->image != 'no-image-middle.png' AND file_exists('img/products/'.$product->path.'/'.$product->image)) {
                            Storage::delete('img/products/'.$product->path.'/'.$product->image);
                        }

                        $this->resizeImage($image, 200, 200, 'img/products/'.$product->path.'/preview-'.$imageName, 100);
                        $introImage = 'preview-'.$imageName;
                    }

                    // $watermark = Image::make('img/watermark.png');
                    $color = 'rgba(0, 0, 0, 0)';

                    // Storing original images
                    $this->resizeImage($image, 1024, 768, 'img/products/'.$product->path.'/'.$imageName, 90, null, $color);

                    // Creating present images
                    $this->resizeImage($image, 250, 250, 'img/products/'.$product->path.'/present-'.$imageName, 100);

                    // Creating mini images
                    $this->resizeImage($image, 100, 100, 'img/products/'.$product->path.'/mini-'.$imageName, 100);

                    if (isset($images[$key])) {

                        if ($images[$key]['image'] != 'no-image-middle.png') {
                            Storage::delete([
                                'img/products/'.$product->path.'/'.$images[$key]['image'],
                                'img/products/'.$product->path.'/'.$images[$key]['present_image'],
                                'img/products/'.$product->path.'/'.$images[$key]['mini_image']
                            ]);
                        }

                        $images[$key]['image'] = $imageName;
                        $images[$key]['present_image'] = 'present-'.$imageName;
                        $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                    else {
                        $images[$key]['image'] = $imageName;
                        $images[$key]['present_image'] = 'present-'.$imageName;
                        $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                }
            }

            $images = array_sort_recursive($images);
        }

        if (isset($request->remove_images) && count($request->remove_images) > 0) {

            foreach ($request->remove_images as $key => $value) {

                if (!isset($request->images[$value])) {

                    if ($product->image === 'preview-'.$images[$value]['image']) {

                        Storage::delete('img/products/'.$product->path.'/'.$product->image);
                        $introImage = 'no-image-middle.png';
                    }

                    Storage::delete([
                        'img/products/'.$product->path.'/'.$images[$value]['image'],
                        'img/products/'.$product->path.'/'.$images[$value]['present_image'],
                        'img/products/'.$product->path.'/'.$images[$value]['mini_image']
                    ]);

                    unset($images[$value]);
                }
            }

            $images = array_sort_recursive($images);
        }

        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->category_id = $request->category_id;
        $product->slug = str_slug($request->title);
        $product->title = $request->title;
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->days = $request->days;
        $product->count = $request->count;
        $product->condition = $request->condition;
        $product->presense = $request->presense;
        $product->meta_description = $request->meta_description;
        $product->description = $request->description;
        $product->characteristic = (isset($request->characteristic)) ? $request->characteristic : '';
        if (isset($introImage)) $product->image = $introImage;
        $product->images = serialize($images);
        $product->lang = $request->lang;
        // $product->mode = $request->mode;
        $product->status = ($request->status == 'on') ? 1 : 0;
        $product->save();

        if ( ! is_null($request->modes_id)) {
            $product->modes()->sync($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->sync($request->options_id);
        }

        return redirect('admin/products')->with('status', 'Товар обновлен!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (! empty($product->images)) {

            $images = unserialize($product->images);

            foreach ($images as $image)
            {
                if ($product->image != NULL AND $product->image != 'no-image-middle.png' AND file_exists('img/products/'.$product->path.'/'.$product->image)) {
                    Storage::delete('img/products/'.$product->path.'/'.$product->image);
                }

                if ($image['image'] != 'no-image-middle.png') {
                    Storage::delete([
                        'img/products/'.$product->path.'/'.$image['image'],
                        'img/products/'.$product->path.'/'.$image['present_image'],
                        'img/products/'.$product->path.'/'.$image['mini_image']
                    ]);
                }
            }

            Storage::deleteDirectory('img/products/'.$product->path);
        }

        $product->delete();

        return redirect('/admin/products');
    }

}