<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Rules\ValidatePrice;


class ProductController extends Controller
{
    public function addProduct(Request $request){
        $data = [
            'pageTitle' => 'Add Product',
            'categories'=>Category::orderBy('category_name','asc')->get()
        ];
        return view('back.pages.seller.add-product',$data);
    }

    public function getProductCategory(Request $request){
        $category_id = $request->category_id;
        $category = Category::findOrfail($category_id);
        $subcategories = SubCategory::where('category_id',$category_id)
                                    ->where('is_child_of',0)
                                    ->orderBy('subcategory_name','asc')
                                    ->get();
        
        $html = '';
        foreach($subcategories as $item){
            $html .= '<option value="'.$item->id.'">'.$item->subcategory_name.'</option>';
            if(count($item->children)>0){
                foreach($item->children as $child){
                    $html .= '<option value="'.$child->id.'">--'.$child->subcategory_name.'</option>';
                }
            }
        }
        return response()->json(['status'=>1,'data'=>$html]);
    }//end method

    public function createProduct(Request $request){
        $request->validate([
            'name'=>'required|unique:products,name',
            'summary'=>'required|min:100',
            'category'=>'required|exists:categories,id',
            'subcategory'=>'required|exists:sub_categories,id',
            'product_image'=>'required|mimes:jpg,jpeg,png|max:1024',
            'price'=>['required',new ValidatePrice],
            'compare_price'=>['nullable',new ValidatePrice],
        ],[
            'name.required'=>'Enter product name',
            'name.unique'=>'Product name already exists',
            'summary.required'=>'Enter product summary',
            'product_image_required'=>'Select product image',
            'category.required'=>'Select category',
            'subcategory.required'=>'Select subcategory',
            'price.required'=>'Enter product price',
        ]);

        $product_image = null;
        if ($request->hasFile('product_image') ){
            $path = 'images/products/';
            $file = $request->file('product_image');
            $filename = 'PIMG_'.time().uniqid().'.'.$file->getClientOriginalExtension();
            $upload = $file->move(public_path($path),$filename);

            if($upload){
                $product_image = $filename;
            }
        }

        //save product details
        $product = new Product();
        $product->user_type = 'seller';
        $product->seller_id = auth('seller')->id();
        $product->name = $request->name;
        $product->summary = $request->summary;
        $product->category = $request->category;
        $product->subcategory = $request->subcategory;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->visibility = $request->visibility;
        $product->product_image = $product_image;
        $saved = $product->save();

        if( $saved ){
            return response()->json(['status'=>1,'msg'=>'Product added successfully']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Failed to add product']);
        }
    }

    public function allProducts(Request $request){
        $data = [
            'pageTitle'=>'My Products'
        ];
        return view('back.pages.seller.products',$data);
    }
}
