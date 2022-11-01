<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_url',
        'product_name',
        'update_interval',
        'store',
        'price',
    ];

    protected $attributes = [
        'update_interval' => 24,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user')->withTimestamps()->withPivot('enabled', 'type', 'threshold');
    }
}
