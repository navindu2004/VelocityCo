<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleCategoryStoreRequest;
use App\Http\Requests\VehicleCategoryUpdateRequest;


class VehicleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicleCategories = VehicleCategory::paginate(10); // Adjust the number as needed

        return view('vehicle-categories.index', [
            'categories' => $vehicleCategories
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('vehicle-categories.form', [
            'category' => new VehicleCategory()
        ]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleCategoryStoreRequest $request)
    {

        VehicleCategory::create([
            'vehicle_category_name' => $request->get('vehicle_category_name'),
            'brand' => $request->get('brand'),
            'model' => $request->get('model'),
            'year' => $request->get('year'),
            'color' => $request->get('color'),
            'plate_number' => $request->get('plate_number'),
            'price' => $request->get('price'),
        ]);

        return redirect()->route('vehicle-categories.index');
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
        return view('vehicle-categories.form', [
            'category' => $vehicleCategory
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleCategoryUpdateRequest $request, VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->update([
            'vehicle_category_name' => $request->get('vehicle_category_name'),
            'brand' => $request->get('brand'),
            'model' => $request->get('model'),
            'year' => $request->get('year'),
            'color' => $request->get('color'),
            'plate_number' => $request->get('plate_number'),
            'price' => $request->get('price'),
        ]);

        return redirect()->route('vehicle-categories.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->delete();

        return redirect()->route('vehicle-categories.index')
            ->with('success', 'Vehicle category deleted successfully.');
    }
}
