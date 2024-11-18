<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
         'sale_id',
         'book_id',
         'quantity',
         'unit_price',
         'total'
    ];

    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function sale():BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
