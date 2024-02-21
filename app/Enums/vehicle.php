<?php

namespace App\Enums;

enum vehicle:int{
    case category_id=1;
    case name=2;
    case model=3;
    case year=4;
    case color =5;
    case license_plate=6;
    case chassis_number=7;
    case engine_number=8;
    case purchase_date=9;
    case purchase_price=10;
    case status=11;
}