<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    // Menampilkan semua produk (READ)
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

    // Menyimpan produk baru ke database (CREATE)
    public function store(StoreProductRequest $request)
    {
        // Validasi sudah dilakukan otomatis oleh FormRequest
        $validated = $request->validated();

        try {
            Product::create($validated);

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage());
        }
    }

    // Menampilkan detail produk (READ)
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Menampilkan form untuk edit produk
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Mengupdate produk di database (UPDATE)
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Validasi sudah dilakukan otomatis oleh FormRequest
        $validated = $request->validated();

        try {
            $product->update($validated);

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage());
        }
    }

    // Menghapus produk dari database (DELETE)
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}