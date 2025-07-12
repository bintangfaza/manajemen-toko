<?php

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route utama
Route::get('/', function () {
    return view('welcome');
});

// Route untuk praktek Eloquent
Route::get('/praktek-eloquent', function () {
    echo "<h1>Praktek Eloquent ORM</h1>";

    // 1. Mengambil semua data dengan all()
    echo "<h3>1. Mengambil semua produk (all())</h3>";
    $products = Product::all();
    foreach ($products as $product) {
        echo "- {$product->name} - Rp. " . number_format($product->price) . "<br>";
    }

    // 2. Mencari data dengan find()
    echo "<h3>2. Mencari produk dengan ID 1 (find())</h3>";
    $product = Product::find(1);
    if ($product) {
        echo "Produk: {$product->name} - Stok: {$product->stock}<br>";
    }

    // 3. Mencari data dengan where()
    echo "<h3>3. Mencari produk dengan harga > 4000 (where())</h3>";
    $expensiveProducts = Product::where('price', '>', 4000)->get();
    foreach ($expensiveProducts as $product) {
        echo "- {$product->name} - Rp. " . number_format($product->price) . "<br>";
    }

    // 4. Membuat data baru dengan create()
    echo "<h3>4. Membuat produk baru (create())</h3>";
    $newProduct = Product::create([
        'name' => 'Kopi Kapal Api',
        'description' => 'Kopi bubuk sachet',
        'price' => 2000.00,
        'stock' => 25,
        'barcode' => '8999999004',
    ]);
    echo "Produk baru dibuat: {$newProduct->name}<br>";

    // 5. Update data dengan update()
    echo "<h3>5. Update stok produk (update())</h3>";
    $product = Product::find(1);
    $oldStock = $product->stock;
    $product->update(['stock' => $product->stock - 5]);
    echo "Stok {$product->name} diupdate dari {$oldStock} menjadi {$product->stock}<br>";

    // 6. Menampilkan relasi
    echo "<h3>6. Menampilkan relasi User dan Transaction</h3>";
    $user = User::find(1);
    echo "User: {$user->name} - Role: {$user->role}<br>";
    echo "Jumlah transaksi: " . $user->transactions->count() . "<br>";

    // 7. Membuat transaksi dengan relasi
    echo "<h3>7. Membuat transaksi baru</h3>";
    $transaction = Transaction::create([
        'user_id' => 1,
        'transaction_code' => 'TRX001',
        'total_amount' => 15000.00,
        'paid_amount' => 20000.00,
        'change_amount' => 5000.00,
    ]);

    // Menambahkan item transaksi
    TransactionItem::create([
        'transaction_id' => $transaction->id,
        'product_id' => 1,
        'quantity' => 2,
        'price' => 3500.00,
        'total' => 7000.00,
    ]);

    TransactionItem::create([
        'transaction_id' => $transaction->id,
        'product_id' => 2,
        'quantity' => 2,
        'price' => 4000.00,
        'total' => 8000.00,
    ]);

    echo "Transaksi {$transaction->transaction_code} berhasil dibuat<br>";

    // 8. Menampilkan relasi transaction dengan items
    echo "<h3>8. Detail transaksi dengan relasi</h3>";
    $transaction = Transaction::with('transactionItems.product')->find($transaction->id);
    echo "Kode Transaksi: {$transaction->transaction_code}<br>";
    echo "Total: Rp. " . number_format($transaction->total_amount) . "<br>";
    echo "Items:<br>";
    foreach ($transaction->transactionItems as $item) {
        echo "- {$item->product->name} x{$item->quantity} = Rp. " . number_format($item->total) . "<br>";
    }

    // 9. Delete data
    echo "<h3>9. Menghapus produk (delete())</h3>";
    $productToDelete = Product::find(4); // Produk yang baru dibuat
    if ($productToDelete) {
        $name = $productToDelete->name;
        $productToDelete->delete();
        echo "Produk {$name} berhasil dihapus<br>";
    }

    return "<br><h3>Praktek Eloquent selesai!</h3>";
});

// === PRAKTEK ROUTING DASAR ===

// 1. Route GET sederhana
Route::get('/products-simple', function () {
    $products = Product::all();
    return view('products.simple', compact('products'));
})->name('products.simple');

// 2. Route dengan parameter
Route::get('/product/{id}', function ($id) {
    $product = Product::find($id);
    if (!$product) {
        return abort(404, 'Produk tidak ditemukan');
    }
    return "Produk: {$product->name} - Harga: Rp. " . number_format($product->price);
})->name('product.detail');

// 3. Route dengan parameter opsional
Route::get('/products-by-price/{min?}', function ($min = 0) {
    $products = Product::where('price', '>=', $min)->get();
    return "Produk dengan harga >= Rp. " . number_format($min) . ": " . $products->count() . " produk";
})->name('products.by.price');

// === RESOURCE CONTROLLER ===

// 4. Resource route untuk produk (7 route otomatis)
Route::resource('products', ProductController::class);

// 5. Resource route untuk transaksi (hanya yang diperlukan)
Route::resource('transactions', TransactionController::class)
    ->only(['index', 'create', 'store', 'show']);

// === ROUTE GROUPING ===

// 6. Group route dengan prefix admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Admin Dashboard";
    })->name('admin.dashboard');

    Route::get('/users', function () {
        $users = User::all();
        return "Total Users: " . $users->count();
    })->name('admin.users');

    Route::get('/reports', function () {
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_amount');
        return "Total Transaksi: {$totalTransactions}, Total Pendapatan: Rp. " . number_format($totalRevenue);
    })->name('admin.reports');
});

// 7. Group route dengan middleware (simulasi)
Route::group(['prefix' => 'kasir', 'as' => 'kasir.'], function () {
    Route::get('/pos', function () {
        return "Point of Sale System";
    })->name('pos');

    Route::get('/sales', function () {
        return "Data Penjualan Kasir";
    })->name('sales');
});

// === ROUTE DENGAN BERBAGAI HTTP METHOD ===

// 8. Route untuk API-like endpoints
Route::get('/api/products', function () {
    return response()->json(Product::all());
})->name('api.products.index');

Route::post('/api/products', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
    ]);

    $product = Product::create($validated);
    return response()->json($product, 201);
})->name('api.products.store');

// 9. Route untuk praktek HTTP methods
Route::get('/test-routes', function () {
    $routes = [
        'GET /products' => route('products.index'),
        'POST /products' => route('products.store'),
        'GET /products/{id}' => route('products.show', 1),
        'PUT /products/{id}' => route('products.update', 1),
        'DELETE /products/{id}' => route('products.destroy', 1),
    ];

    return view('test-routes', compact('routes'));
})->name('test.routes');
