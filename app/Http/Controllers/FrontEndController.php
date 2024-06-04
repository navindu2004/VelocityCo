<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class FrontEndController extends Controller
{
    public function homePage(Request $request){
        $data = [
            'pageTitle'=>'Velocity Co | Car Dealership Website'
        ];
        return view('front.pages.home', $data);
    }

    
}
