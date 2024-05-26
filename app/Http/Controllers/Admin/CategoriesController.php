<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\SubCategory;

class CategoriesController extends Controller
{
    public function catSubcatList(Request $request){
        $data = [
            'pageTitle'=>'Categories and Sub categories management'
        ];
        return view('back.pages.admin.cats-subcats-list',$data);
    }

    public function addCategory(Request $request){
        $data = [
            'pageTitle'=>'Add Category'
        ];
        return view('back.pages.admin.add-category',$data);
    }

    public function storeCategory(Request $request){
        $request->validate([
            'category_name'=>'required|min:5|unique:categories,category_name',
            'category_image'=>'required|image|mimes:jpeg,png,jpg,svg'
        ],[
            'category_name.required'=>':Attribute is required',
            'category_name.min'=>':Attribute must be at least 5 characters',
            'category_name.unique'=>':Attribute already exists',
            'category_image.required'=>':Attribute is required',
            'category_image.image'=>':Attribute must be an image',
            'category_image.mimes'=>':Attribute must be of type jpeg, png, jpg or svg'
        ]);

        if( $request->hasFile('category_image') ){
            $path = 'images/categories/';
            $file = $request->file('category_image');
            $filename = time().'_'.$file->getClientOriginalName();

            if(!File::exists(public_path($path))){
                File::makeDirectory(public_path($path));
            }

            //upload category image
            $upload = $file->move(public_path($path),$filename);

            if($upload){
                //save category to database
                $category = new Category();
                $category->category_name = $request->category_name;
                $category->category_image = $filename;
                $saved = $category->save();

                if($saved){
                    return redirect()->route('admin.manage-categories.add-category')->with('success','<b>'.ucfirst($request->category_name).'</b> Category added successfully.');
                }else{
                    return redirect()->route('admin.manage-categories.add-category')->with('fail','Something went wrong, please try again.');
                }
            }else{
                return redirect()->route('admin.manage-categories.add-category')->with('fail','Something went wrong while uploading category image');
            }
        }
        
    }

    public function editCategory(Request $request){
        $category_id = $request->id;
        $category = Category::findOrFail($category_id);
        $data = [
            'pageTitle'=>'Edit Category',
            'category'=>$category
        ];
        return view('back.pages.admin.edit-category',$data);
    }

    public function updateCategory(Request $request){
        $category_id = $request->category_id;
        $category = Category::findOrFail($category_id);

        //Validate the form
        $request->validate([
            'category_name'=>'required|min:5|unique:categories,category_name,'.$category_id,
            'category_image'=>'nullable|image|mimes:jpeg,png,jpg,svg'
        ],[
            'category_name.required'=>':Attribute is required',
            'category_name.min'=>':Attribute must be at least 5 characters',
            'category_name.unique'=>':Attribute already exists',
            'category_image.image'=>':Attribute must be an image',
            'category_image.mimes'=>':Attribute must be of type jpeg, png, jpg or svg'
        ]);

        if( $request->hasFile('category_image') ){
            $path = 'images/categories/';
            $file = $request->file('category_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $old_category_image = $category->category_image;

            //upload new category image
            $upload = $file->move(public_path($path),$filename);

            if($upload){
                //delete old category image
                if(File::exists(public_path($path.$old_category_image))){
                    File::delete(public_path($path.$old_category_image));
                }
                //update category info
                $category->category_name = $request->category_name;
                $category->category_image = $filename;
                $category->category_slug = null;
                $saved = $category->save();

                if($saved){
                    return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('success','<b>'.ucfirst($request->category_name).'</b> Category updated successfully.');
                }else{
                    return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('fail','Error in uploading category image');
                }

            }else{
                return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('fail','Error in uploading cateogory image');
            }

        }else{
            //update category info
            $category->category_name = $request->category_name;
            $category->category_slug = null;
            $saved = $category->save();

            if($saved){
                return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('success','<b>'.ucfirst($request->category_name).'</b> Category updated successfully.');
        }else{
            return redirect()->route('admin.manage-categories.edit-category',['id'=>$category_id])->with('fail','Something went wrong, please try again.');
        }
    }
}

public function addSubCategory(Request $request){
    $independent_subcategories = SubCategory::where('is_child_of',0)->get();
    $categories = Category::all();
    $data = [
        'pageTitle'=>'Add Sub Category',
        'categories'=>$categories,
        'subcategories'=>$independent_subcategories
    ];

    return view('back.pages.admin.add-subcategory',$data);
}

public function storeSubCategory(Request $request){
    //validate the form
    $request->validate([
        'parent_category'=>'required|exists:categories,id',
        'subcategory_name'=>'required|min:5|unique:sub_categories,subcategory_name',
    ],[
        'parent_category.required'=>':Attribute is required',
        'parent_category.exists'=>':Attribute does not exist in categories table',
        'subcategory_name.required'=>':Attribute is required',
        'subcategory_name.min'=>':Attribute must be at least 5 characters',
        'subcategory_name.unique'=>':Attribute already exists'
    ]);

    $subcategory = new SubCategory();
    $subcategory->category_id = $request->parent_category;
    $subcategory->subcategory_name = $request->subcategory_name;
    $subcategory->is_child_of = $request->is_child_of;
    $saved = $subcategory->save();

    if($saved){
        return redirect()->route('admin.manage-categories.add-subcategory')->with('success','<b>'.ucfirst($request->subcategory_name).'</b> Sub category added successfully.');
    }else{
        return redirect()->route('admin.manage-categories.add-subcategory')->with('fail','Something went wrong, please try again.');
    }
}

public function editSubCategory(Request $request){
    $subcategory_id = $request->id;
    $subcategory = SubCategory::findOrFail($subcategory_id);
    $independent_subcategories = SubCategory::where('is_child_of',0)->get();
    $data = [
        'pageTitle'=>'Edit Sub Category',
        'categories'=>Category::all(),
        'subcategory'=>$subcategory,
        'subcategories'=>(!empty($independent_subcategories)) ? $independent_subcategories : []
    ];
    return view('back.pages.admin.edit-subcategory',$data);
}

public function updateSubCategory(Request $request){
    $subcategory_id = $request->subcategory_id;
    $subcategory = SubCategory::findOrFail($subcategory_id);

    //validate the form
    $request->validate([
        'parent_category'=>'required|exists:categories,id',
        'subcategory_name'=>'required|min:5|unique:sub_categories,subcategory_name,'.$subcategory_id,
    ],[
        'parent_category.required'=>':Attribute is required',
        'parent_category.exists'=>':Attribute does not exist in categories table',
        'subcategory_name.required'=>':Attribute is required',
        'subcategory_name.min'=>':Attribute must be at least 5 characters',
        'subcategory_name.unique'=>':Attribute already exists'
    ]);

    //check if this sub category has children
    if( $subcategory->children->count() && $request->is_child_of !=0){
        return redirect()->route('admin.manage-categories.edit-subcategory',['id'=>$subcategory_id])->with('fail','This sub category has ('.$subcategory->children()->count().') children. You cannot change its parent category.');
    }else{
        //update category info
        $subcategory->category_id = $request->parent_category;
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->is_child_of = $request->is_child_of;
        $saved = $subcategory->save();

        if( $saved ){
            return redirect()->route('admin.manage-categories.edit-subcategory',['id'=>$subcategory_id])->with('success','<b>'.ucfirst($request->subcategory_name).'</b> Sub category updated successfully.');
        }else{
            return redirect()->route('admin.manage-categories.edit-subcategory',['id'=>$subcategory_id])->with('fail','Something went wrong, please try again.');
        }
    }
}

}
