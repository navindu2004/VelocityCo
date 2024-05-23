<?php

use App\Models\Admin;

class constGuards{
    const ADMIN = 'admin';
    const CLIENT = 'client';
    const SELLER = 'seller';
}

class constDefaults{
    const tokenExpiredMinutes = 15;
}