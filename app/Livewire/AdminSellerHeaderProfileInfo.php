<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class AdminSellerHeaderProfileInfo extends Component
{
    public $admin;
    public $seller;

    public $listeners = [
        'updateAdminSellerHeaderInfo'=>'$refresh'
    ];

    public function mount(){
        if(Auth::guard('admin')->check()){
            $this->admin = Admin::findOrFail(auth('admin')->id());
        }
        if(Auth::guard('seller')->check()){
            $this->seller = Seller::findOrFail(auth('seller')->id());
        }
    }
    public function render()
    {
        return view('livewire.admin-seller-header-profile-info');
    }
}
