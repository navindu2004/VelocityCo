<?php

namespace App\Http\Controllers;


use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\VehicleController;

class VehicleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicleCategories = VehicleCategory::paginate(10); // Adjust the number as needed
        return view ('vehicle-categories.index', compact('vehicleCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('vehicle-categories.form', [
            'vehicleCategory' => new VehicleCategory(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleCategory $vehicleCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleCategory $vehicleCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleCategory $vehicleCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleCategory $vehicleCategory)
    {
        //
    }
}
