<?php

namespace App\Enums;

enum vehicle:int{
    case category_id=1;
    case brand_id=2;
    case name=3;
    case model=4;
    case year=5;
    case color =6;
    case license_plate=7;
    case chassis_number=8;
    case engine_number=9;
    case purchase_date=10;
    case purchase_price=11;
    case status=12;
}