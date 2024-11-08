<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
