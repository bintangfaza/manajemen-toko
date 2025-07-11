<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    // relasi many-to-one: banyak item transaksi dimiliki oleh satu transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // relasi many-to-one: banyak item transaksi dimiliki oleh satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
