<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\Seller;

class SellerProfile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    public $name, $username, $email, $address, $phone;

    protected $queryString = ['tab'=>['keep'=>true]];

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        //populate
        $seller = Seller::findOrFail(auth('seller')->id());
        $this->name = $seller->name;
        $this->username = $seller->username;
        $this->email = $seller->email;
        $this->address = $seller->address;
        $this->phone = $seller->phone;
    }

    public function updateSellerPersonalDetails(){
        $this->validate([
            'name'=>'required|min:5',
            'username'=>'nullable|min:5|unique:sellers,username,'.auth('seller')->id(),
        ]);
        $seller = Seller::findOrFail(auth('seller')->id());
        $seller->name = $this->name;
        $seller->username = $this->username;
        $seller->address = $this->address;
        $seller->phone = $this->phone;
        $update = $seller->save();

        if( $update ){
            $this->dispatch('updateAdminSellerHeaderInfo');
            $this->showToastr('success','Personal Details Updated Successfully');
        }else{
            $this->showToastr('error','Failed to Update Personal Details');
        }
    }

    public function showToastr($type,$message){
        return $this->dispatch('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
    public function render()
    {
        return view('livewire.seller.seller-profile',[
            'seller'=>Seller::findOrFail(auth('seller')->id())
        ]);
    }
}
