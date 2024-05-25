<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\File;
class AdminCategoriesSubcategoriesList extends Component
{
    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory'
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
            'categories'=>Category::orderBy('ordering','asc')->get()
        ]);
    }
}
