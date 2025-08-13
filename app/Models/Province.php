<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
