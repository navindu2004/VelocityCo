<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'model',
        'year',
        'color',
        'license_plate',
        'chassis_number',
        'engine_number',
        'purchase_date',
        'purchase_price',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class);
    }
    
    
}