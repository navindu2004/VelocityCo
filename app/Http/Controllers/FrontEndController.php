<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class FrontEndController extends Controller
{
    public function homePage(Request $request){
        $data = [
            'pageTitle'=>'Velocity Co | Car Dealership Website',
            'categories' => Category::with('subcategories')->get(), // Fetch categories with their subcategories
        ];
        return view('front.pages.home', $data);
    }

    public function showPurchase($id)
{
    $subcategory = SubCategory::with('category')->findOrFail($id);
    return view('front.pages.purchase', ['subcategory' => $subcategory]);
}
    
}
