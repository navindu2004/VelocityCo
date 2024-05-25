<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
class AdminCategoriesSubcategoriesList extends Component
{
    protected $listeners = [
        'updateCategoriesOrdering'
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
