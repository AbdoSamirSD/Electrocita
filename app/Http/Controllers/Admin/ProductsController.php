<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Option;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\File;
class ProductsController extends Controller
{
    public function list()
    {
        $products = Product::paginate(10);
        return view('admin.products.general.index', compact('products'));
    }


    public function create()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('active', 1)->get();
        $tags = Tag::get();
        $attributes = Attribute::get();
        $options = Option::get();
        return view('admin.products.general.create', compact('brands', 'categories', 'tags', 'attributes', 'options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|unique:products,slug', 
            'description' => 'required|max:1000',
            'short_description' => 'required|max:200',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:categories,id',
            'tags' => 'nullable|array|min:1',
            'tags.*' => 'nullable|exists:tags,id',
            'attrs' => 'nullable|array|min:1',
            'attrs.*' => 'nullable|exists:attributes,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|in:0,1',
        ],[
            'name.required' => 'The name field is required',
            'name.max' => 'The name may not be greater than 50 characters',
            'slug.required' => 'The slug field is required',
            'slug.unique' => 'The slug has already been taken',
            'description.required' => 'The description field is required',
            'description.max' => 'The description may not be greater than 1000 characters',
            'short_description.required' => 'The short description field is required',
            'short_description.max' => 'The short description may not be greater than 200 characters',
            'categories.required' => 'The category field is required',
            'categories.array' => 'The category must be an array',
            'categories.min' => 'The category must have at least 1 item',
            'categories.*.required' => 'The category field is required',
            'categories.*.exists' => 'The selected category is invalid',
            'tags.*.exists' => 'The selected tag is invalid',
            'attrs.required' => 'The attribute field is required',
            'attrs.array' => 'The attribute must be an array',
            'attrs.min' => 'The attribute must have at least 1 item',
            'attrs.*.required' => 'The attribute field is required',
            'attrs.*.exists' => 'The selected attribute is invalid',
            'brand_id.required' => 'The brand field is required',
            'brand_id.exists' => 'The selected brand is invalid',
            'status.required' => 'The status field is required',
            'status.in' => 'The status field is invalid',
        ]);
        try{
            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->brand_id = $request->brand_id;
            $product->is_active = $request->status;
            $product->save();
            $product->categories()->attach($request->categories);
            $product->tags()->attach($request->tags);
            foreach ($request['attributes'] as $attributeId) {
                $product->attributes()->attach($attributeId);
            }
            
            return redirect()->route('dashboard.products.getOptions', $product->id)->with('success', 'Product updated successfully. please set options');
        }catch(\Exception $ex){
            return redirect()->route('dashboard.products.general.create')->with('error', 'There was an error adding the product: '. $ex->getMessage());
        }
    }

    public function edit($id){
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('dashboard.products.list')->with('error', 'Product not found');
        }
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('active', 1)->get();
        $tags = Tag::get();
        $attributes = Attribute::get();
        $options = Option::get();
        return view('admin.products.general.edit', compact('product', 'brands', 'categories', 'tags', 'attributes', 'options'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|unique:products,slug,'.$id, 
            'description' => 'required|max:1000',
            'short_description' => 'required|max:200',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:categories,id',
            'tags' => 'nullable|array|min:1',
            'tags.*' => 'nullable|exists:tags,id',
            'attrs' => 'nullable|array|min:1',
            'attrs.*' => 'nullable|exists:attributes,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|in:0,1',
        ],[
            'name.required' => 'The name field is required',
            'name.max' => 'The name may not be greater than 50 characters',
            'slug.required' => 'The slug field is required',
            'slug.unique' => 'The slug has already been taken',
            'description.required' => 'The description field is required',
            'description.max' => 'The description may not be greater than 1000 characters',
            'short_description.required' => 'The short description field is required',
            'short_description.max' => 'The short description may not be greater than 200 characters',
            'categories.required' => 'The category field is required',
            'categories.array' => 'The category must be an array',
            'categories.min' => 'The category must have at least 1 item',
            'categories.*.required' => 'The category field is required',
            'categories.*.exists' => 'The selected category is invalid',
            'tags.*.exists' => 'The selected tag is invalid',
            'attrs.required' => 'The attribute field is required',
            'attrs.array' => 'The attribute must be an array',
            'attrs.min' => 'The attribute must have at least 1 item',
            'attrs.*.required' => 'The attribute field is required',
            'attrs.*.exists' => 'The selected attribute is invalid',
            'brand_id.required' => 'The brand field is required',
            'brand_id.exists' => 'The selected brand is invalid',
            'status.required' => 'The status field is required',
            'status.in' => 'The status field is invalid',
        ]);

        $product = Product::find($id);
        try{
            if(!$product){
                return redirect()->route('dashboard.products.list')->with('error', 'Product not found');
            }
            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'brand_id' => $request->brand_id,
                'is_active' => $request->status,
            ]);

            $product->save();

            if ($request->has('categories')) {
                $product->categories()->sync($request->categories);
            }
            if ($request->has('tags')) {
                $product->tags()->sync($request->tags);
            }
            if ($request->has('attrs')) {
                $product->attributes()->sync($request->attrs);
            }
            return redirect()->route('dashboard.products.getOptions', $product->id)->with('success', 'Product updated successfully. please set options');
        }catch(\Exception $ex){
            return redirect()->route('dashboard.products.general.edit', $product->id)->with('error', 'There was an error updating the product: ' . $ex->getMessage());
        }
    }

    public function getPrice($id)
    {
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('dashboard.prodcts.list')->with('error', 'Product not found');
        }
        return view('admin.products.prices.create', compact('product'));
    }

    public function updatePrice(Request $request){
        $requestData = array_filter($request->all(), function($value) {
            return !is_null($value) && $value !== '';
        });
        
        $request->replace($requestData);

        $request->validate([
            'price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'special_price' => 'numeric|min:0.01',
            'special_price_type' => 'required_with:special_price|in:fixed,percentage',
            'special_price_start' => 'required_with:special_price|date_format:Y-m-d|after_or_equal:today',
            'special_price_end' => 'required_with:special_price|date_format:Y-m-d|after_or_equal:special_price_start',
        ],[
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be a positive number.',
            'product_id.required' => 'The product ID field is required.',
            'product_id.exists' => 'The selected product is invalid.',
            'special_price.numeric' => 'The special price must be a valid number.',
            'special_price.min' => 'The special price must be greater than 0.',
            'special_price_type.required_with' => 'The special price type field is required.',
            'special_price_type.in' => 'The special price type must be either fixed or percentage.',
            'special_price_start.required_with' => 'The special price start date is required.',
            'special_price_start.date_format' => 'The special price start date must be in the format Y-m-d.',
            'special_price_start.after_or_equal' => 'The special price start date must be today or later.',
            'special_price_end.required_with' => 'The special price end date is required.',
            'special_price_end.date_format' => 'The special price end date must be in the format Y-m-d.',
            'special_price_end.after_or_equal' => 'The special price end date must be after or equal to the start date.',
        ]);

        try{
            $product = Product::find($request->product_id);
            if(!$product){
                return redirect()->route('dashboard.products.getprice')->with('Product not found');
            }
            $product->price = $request->price;
            if($request->has('special_price')){
                $product->special_price = $request->special_price;
                $product->special_price_type = $request->special_price_type;
                $product->special_price_start = $request->special_price_start;
                $product->special_price_end = $request->special_price_end;
            }else {
                $product->special_price = null;
                $product->special_price_type = null;
                $product->special_price_start = null;
                $product->special_price_end = null;
            }
            $product->save();
            return redirect()->route('dashboard.products.getprice', $product->id)->with('success', 'Price Updated Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error in updating price. try again later: '.$e->getMessage());
        }
    }

    public function getStock($id)
    {
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('dashboard.products.list')->with('error', 'Product not found');
        }
        return view('admin.products.stock.create', compact('product'));
    }

    public function updateStock(Request $request){
        $request->validate([
            'sku' => 'required|string|min:8|max:32|unique:products,sku',
            'product_id' => 'required|exists:products,id',
            'track_stock' => 'required|numeric|in:0,1',
            'status' => 'required|numeric|in:0,1', //in_stock
            'qty' => 'nullable|required_if:track_stock,1|numeric|min:1',
        ],[
            'sku.required' => 'The SKU field is required.',
            'sku.string' => 'The SKU must be a string.',
            'sku.min' => 'The SKU must be at least 8 characters.',
            'sku.max' => 'The SKU may not be greater than 32 characters.',
            'sku.unique' => 'The SKU has already been taken.',
            'product_id.required' => 'The product ID field is required.',
            'product_id.exists' => 'The selected product is invalid.',
            'track_stock.required' => 'The track stock field is required.',
            'track_stock.numeric' => 'The track stock must be a number.',
            'track_stock.in' => 'The track stock field is invalid.',
            'status.required' => 'The status field is required.',
            'status.numeric' => 'The status must be a number.',
            'status.in' => 'The status field is invalid.',
            'qty.required_if' => 'The qty field is required.',
            'qty.numeric' => 'The qty must be a valid number.',
            'qty.min' => 'The qty must be at least 1.',
        ]);
        try{
            $product = Product::find($request->product_id);
            if(!$product){
                return redirect()->route('dashboard.products.getstock')->with('error', 'Product not found');
            }
            $product->sku = $request->sku;
            $product->in_stock = $request->status;
            if($request->track_stock == 1){
                $product->manage_stock = 1;
                $product->quantity = $request->qty;
            }else{
                $product->manage_stock = 0;
                $product->quantity = 0;
            }
            $product->save();
            return redirect()->route('dashboard.products.getstock', $product->id)->with('success', 'Stock Updated Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error in updating stock. try again later: '.$e->getMessage());
        }
    }

    public function getImages($id){
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('dashboard.products.list')->with('error', 'Product not found');
        }
        $images = ProductImage::where('product_id', $id)->get();
        return view('admin.products.images.create', compact('product', 'images'));
    }

    public function updateImages(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image'=> 'required|image|mimes:png,jpg,jpeg,heic,svg'
        ],[
            'product_id.required' => 'The product ID field is required.',
            'product_id.exists' => 'The selected product is invalid.',
            'image.required' => 'The image field is required.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: png, jpg, jpeg, heic, svg.',
        ]);

        try{
            $product = Product::find($request->product_id);
            if(!$product){
                return redirect()->route('dashboard.products.getimage')->with('error', 'Product not found');
            }
            if($request->hasFile('image')){
                $productImage = new ProductImage();
                $img = $request->file('image');
                $filename = time().'_'.$img->getClientOriginalName();
                $path = '/uploads/products';
                $img->move(public_path($path), $filename);
                $productImage->product_id = $request->product_id;
                $productImage->path = $path . '/' . $filename;
                $productImage->save();
            }
            return redirect()->route('dashboard.products.getimage', $product->id)->with('success', 'Image Uploaded Successfully');
           }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error in uploading image. try again later: '.$e->getMessage());
        }
    }

    public function destroyImage($id){
        $image = ProductImage::find($id);
        if(!$image){
            return redirect()->route('dashboard.products.list')->with('error', 'Image not found');
        }
        try{
            if(File::exists(public_path($image->path))){
                File::delete(public_path($image->path));
                $image->delete();
                return redirect()->back()->with('success', 'Image deleted successfully');
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error in deleting image. try again later: '.$e->getMessage());
        }
    }

    public function getOptions($id){
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('dashboard.products.list')->with('error', 'Product not found');
        }

        $attributes = Attribute::get();
        $productAttributes = $product->attributes()->pluck('attribute_id');
        $options = Option::whereIn('attribute_id', $productAttributes)->get();
        // dd($options);
        return view('admin.products.options.create', compact('product', 'attributes', 'options'));
    }

    public function updateOptions(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'options' => 'required|array|min:1',
            'options.*' => 'required|exists:options,id',
        ],[
            'product_id.required' => 'The product ID field is required.',
            'product_id.exists' => 'The selected product is invalid.',
            'options.required' => 'The options field is required.',
            'options.array' => 'The options must be an array.',
            'options.min' => 'The options must have at least 1 item.',
            'options.*.required' => 'The selected option is invalid.',
            'options.*.exists' => 'The selected option is invalid.',
        ]);

        // dd($request);
        try{
            $product = Product::find($request->product_id);
            if(!$product){
                return redirect()->route('dashboard.products.getOptions')->with('error', 'Product not found');
            }
            $product->options()->sync($request->options);
            return redirect()->route('dashboard.products.getOptions', $product->id)->with('success', 'Options Updated Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error in updating options. try again later: '.$e->getMessage());
        }
    }

}
