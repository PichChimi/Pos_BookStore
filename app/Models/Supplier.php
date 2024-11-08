<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_kh',
        'p_number',
        'company',
        'address_en',
        'address_kh',
    ];
}
