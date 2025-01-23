<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;

    protected $table = 'stock_mutation';

    protected $fillable = [
        'product_id',
        'quantity',
        'mutation_type',
        'mutation_date',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'mutation_date' => 'datetime',
    ];

    public function productInventory()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
