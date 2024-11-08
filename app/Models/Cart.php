<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Book;
use App\Models\Stock;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
            'book_id',
            'stock_id',
            'quantity',
            'total'
    ];
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

}
