<?php

namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;


class VehicleCategoryStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**

     *
     * @return array
     */
    public function rules()
    {
        return [
            'vehicle_category_name' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'color' => 'required',
            'plate_number' => 'required',
            'price' => 'required',

        ];
    }
}
