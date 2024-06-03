<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\Product;
use App\Models\Seller;
use Livewire\WithPagination;


class Products extends Component
{
    use WithPagination;

    public $perPage = 9;
    public function render()
    {
        return view('livewire.seller.products',[
            'products'=>Product::where('user_-type','seller')
                                ->where('seller_id',auth('seller')->id())
                                ->paginate($this->perPage),
        ]);
    }
}
