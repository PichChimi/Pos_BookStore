<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Authors;
use App\Models\Genres;
use App\Models\Stock;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_kh',
        'barcode',
        'des',
        'cover_book',
        'authors_id',
        'genres_id'
    ];

    public function authore(): BelongsTo
    {
        return $this->belongsTo(Authors::class);
    }

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genres::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }


}
