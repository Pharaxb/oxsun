<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdLocation extends Model
{
    protected $fillable = [
        'ad_id',
        'province_id',
        'city_id',
        'district_id',
        'view'
    ];
}
