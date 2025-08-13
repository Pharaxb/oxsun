<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    protected $fillable = [
        'uuid',
        'title',
        'description',
        'file',
        'file_type',
        'circulation',
        'viewed',
        'cost',
        'commission',
        'gender',
        'operator_id',
        'min_age',
        'max_age',
        'status_id',
        'is_verify',
        'admin_id',
        'comment',
        'start_date',
        'end_date',
    ];

    public function adLocations(): HasMany
    {
        return $this->hasMany(AdLocation::class);
    }

    public function adUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ad_user', 'ad_id', 'user_id')->withPivot('status')->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
