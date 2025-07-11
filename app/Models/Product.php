<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // menentukan kolom yang dapat diisi
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'barcode',
    ];

    // relasi one-to-many dengan TransactionItem
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // relasi many-to-many dengan Transaction melalui TransactionItem
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_items')
            ->withPivot('quantity', 'price', 'total')
            ->withTimestamps();
    }
}
