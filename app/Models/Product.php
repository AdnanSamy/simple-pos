<?php

namespace App\Models;

use App\Models\StockMutation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    //
    protected $table = 'product';

    protected $fillable = [
        'name',
        'price',
        'stock_qty',
    ];

    public function stockMutations(): HasMany
    {
        return $this->hasMany(StockMutation::class, 'product_id');
    }

    public function getStockQtyAttribute(): int
    {
        return $this->stockMutations()
            ->selectRaw("SUM(CASE WHEN mutation_type = 'IN' THEN quantity ELSE 0 END) -
                         SUM(CASE WHEN mutation_type = 'OUT' THEN quantity ELSE 0 END) as stock_qty")
            ->value('stock_qty') ?? 0;
    }
}
