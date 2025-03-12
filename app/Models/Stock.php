<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Supplier;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'quantity',
        'purchase_price',
        'selling_price',
        'supplier_id'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }


}
