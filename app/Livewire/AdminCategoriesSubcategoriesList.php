<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use App\Models\Subcategory;
class AdminCategoriesSubcategoriesList extends Component
{
    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory',
        'updateSubCategoriesOrdering',
        'updateChildSubCategoriesOrdering',
        'deleteSubCategory',
    ];

    public function updateCategoriesOrdering($positions)
    {
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id',$index)->update(['ordering'=>$newPosition
        ]);

        $this->showToastr('success','Categories ordering updated successfully');
        }
    }

    public function updateSubCategoriesOrdering($positions)
    {
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Subcategory::where('id',$index)->update(['ordering'=>$newPosition
        ]);

        $this->showToastr('success','Subcategories ordering updated successfully');
        } //ask sir
    }

    public function updateChildSubCategoriesOrdering($positions)
    {
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Subcategory::where('id',$index)->update(['ordering'=>$newPosition
        ]);

        $this->showToastr('success','Child subcategories ordering updated successfully');
        }
    }

    public function deleteCategory($category_id){
        $category = Category::findOrFail($category_id);
        $path = 'images/categories/';
        $category_image = $category->category_image;

        //check if this category has subcategories

        //delete category image
        if(File::exists(public_path($path.$category_image))){
            File::delete($path.$category_image);
        }

        //delete category from db
        $delete = $category->delete();

        if( $delete ){
            $this->showToastr('success','Category deleted successfully');
        }else{
            $this->showToastr('error','Something went wrong, please try again');
        }
    }

    public function deleteSubCategory($subcategory_id){
        $subcategory = Subcategory::findOrFail($subcategory_id);
        
        //when this sub category has child sub categories
        if( $subcategory->children->count() > 0){
            //check if there is/are products related to one of child sub categories

            //if no product(s) related to child sub categories, delete them
            foreach($subcategory->children as $child){
                SubCategory::where('id',$child->id)->delete();
            }

            //delete sub category
            $subcategory->delete();
            $this->showToastr('success','Subcategory deleted successfully');
        }else{
            //check if this sub category has products related to it

            //delete sub category
            $subcategory->delete();
            $this->showToastr('success','Subcategory deleted successfully');
        }
    }

    public function showToastr($type, $message){
        return $this->dispatchBrowserEvent('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
    public function render()
    {
        return view('livewire.admin-categories-subcategories-list',[
            'categories'=>Category::orderBy('ordering','asc')->get(),
            'subcategories'=>SubCategory::where('is_child_of',0)->orderBy('ordering','asc')->get()
        ]);
    }
}
