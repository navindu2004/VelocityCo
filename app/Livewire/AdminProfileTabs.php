<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminProfileTabs extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'];
    public $name, $email, $type, $admin_id;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        if(Auth::guard('admin')->check()){
            $admin = Admin::findOrFail(auth()->id());
            $this->name = $admin->name;
            $this->email = $admin->email;
            $this->type = $admin->type;
            $this->admin_id = $admin->id;
        }
    }

    public function updateAdminPersonalDetails(){
        $this->validate([
            'name'=>'required|min:5',
            'email'=>'required|email|unique:admins,email,'.$this->admin_id,
            'type'=>'required|min:3|unique:admins,type,'.$this->admin_id
        ]);

        Admin::find($this->admin_id)->update([
            'name'=>$this->name,
            'email'=>$this->email,
            'type'=>$this->type
        ]);

        $this->emit('updateAdminSellerHeaderInfo'); // this will emit an event to update the admin header info (name and email)
        $this->dispatchBrowserEvent('updateAdminInfo',[
            'adminName'=>$this->name,
            'adminEmail'=>$this->email
        ]);
        $this->showToastr('success', 'Admin personal details updated successfully');
        
    }

    public function showToastr($type, $message){
        return $this->dispatchBrowserEvent('showToastr', ['type'=>$type, 'message'=>$message]);
    }
    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}
