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
