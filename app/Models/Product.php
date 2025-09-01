<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'image',
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

    // Method untuk mendapatkan URL gambar
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return asset('images/no-image.png'); // gambar default jika tidak ada
    } 

    // Method untuk menghapus gambar lama
    public function deleteImage()
    {
        if ($this->image && Storage::exists($this->image)) {
            Storage::delete($this->image);
        }
    }

    // Method untuk pencarian produk
    public static function search($query = '')
    {
        return self::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('barcode', 'LIKE', "%{$query}%");
    }

    // Method untuk filter berdasarkan stok
    public static function filterByStock($status = 'all')
    {
        switch ($status) {
            case 'low':
                return self::where('stock', '<=', 10);
            case 'empty':
                return self::where('stock', 0);
            case 'available':
                return self::where('stock', '>', 0);
            default:
                return self::query();
        }
    }
}
