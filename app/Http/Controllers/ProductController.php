<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar semua produk
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru ke database
    public function store(StoreProductRequest $request)
    {
        // Validasi data sudah dilakukan di StoreProductRequest
        Product::create($request->validated());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }
    // Menampilkan detail produk tertentu
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Menampilkan form untuk edit produk
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Mengupdate data produk di database
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Validasi data sudah dilakukan di UpdateProductRequest
        $product->update($request->validated());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }
    // Menghapus produk dari database
    public function destroy(Product $product)
    {
        $product->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}