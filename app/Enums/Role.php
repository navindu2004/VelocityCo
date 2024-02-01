<?php

namespace App\Enums;

enum Role : int {

    case Administrator = 1;
    case Customer = 2;
    case Seller = 3;
    case CustomerSupport = 4;


}