<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleDetail;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',
        'employee_id',
        'sub_total',
        'total',
        'coupon',
        'recived_amount',
        'change_return'
    ];

    public function details():HasMany
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }

    public function employee()
{
    return $this->belongsTo(User::class, 'employee_id');
}

}
