<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_code',
        'total_amount',
        'paid_amount',
        'change_amount',
    ];

    // relasi many-to-one : banyak transaksi dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi one-to-many: satu produk bisa ada di banyak transaksi
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // relasi many-to-many dengan Product melalui TransactionItem
    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_items')
            ->withPivot('quantity', 'price', 'total')
            ->withTimestamps();
    }
}
