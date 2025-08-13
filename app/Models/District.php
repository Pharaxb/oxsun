<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'city_id',
        'name',
        'is_active'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
