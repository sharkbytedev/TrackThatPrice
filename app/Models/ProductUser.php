<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProductUser extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "product_id",
        "user_id"
    ];

}


