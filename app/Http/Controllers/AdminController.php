<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $usertype = Auth()->user()->usertype;

            if($usertype=='user')
            {
                return view('customer');
            }

            else if($usertype=='admin')
            {
                return view('admin');
            }
            else {
                return redirect()->route('login');
            }
        }
    }
}
