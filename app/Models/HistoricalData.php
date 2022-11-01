<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
