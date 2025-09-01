<?php

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route utama
Route::get('/', function () {
    return view('welcome');
});

// Route Breeze Authentication
require __DIR__ . '/auth.php';

// Route yang memerlukan login
Route::middleware(['auth'])->group(function () {

    // Dashboard berdasarkan role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isKasir()) {
            return redirect()->route('kasir.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');

    // Route untuk semua user yang sudah login
    Route::get('/products-simple', function () {
        $products = Product::all();
        return view('products.simple', compact('products'));
    })->name('products.simple');

    Route::get('/product/{id}', function ($id) {
        $product = Product::find($id);
        if (!$product) {
            return abort(404, 'Produk tidak ditemukan');
        }
        return "Produk: {$product->name} - Harga: Rp. " . number_format($product->price);
    })->name('product.detail');
});

// Route khusus ADMIN
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalUsers = User::count();
        $totalRevenue = Transaction::sum('total_amount');

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'totalUsers',
            'totalRevenue'
        ));
    })->name('admin.dashboard');


    // Manajemen Produk (hanya admin)
    Route::resource('products', ProductController::class);

    // Reports (hanya admin)
    Route::get('/admin/reports', function () {
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_amount');
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports', compact(
            'totalTransactions',
            'totalRevenue',
            'recentTransactions'
        ));
    })->name('admin.reports');


    // Manajemen User (hanya admin)
    Route::get('/admin/users', function () {
        $users = User::all();
        return view('admin.users', compact('users'));
    })->name('admin.users');

    Route::resource('/admin/users', UserController::class)
        ->only(['index', 'destroy', 'edit', 'update'])
        ->names([
            'index' => 'admin.users.index',
            'destroy' => 'admin.users.destroy',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
        ]);
});

// Route khusus KASIR
Route::middleware(['auth', 'kasir'])->group(function () {

    // Dashboard Kasir
    Route::get('/kasir/dashboard', function () {
        $user = auth()->user();
        $todayTransactions = Transaction::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();
        $todayRevenue = Transaction::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->sum('total_amount');

        return view('kasir.dashboard', compact('todayTransactions', 'todayRevenue'));
    })->name('kasir.dashboard');

    // POS System
    Route::get('/kasir/pos', function () {
        $products = Product::where('stock', '>', 0)->get();
        return view('kasir.pos', compact('products'));
    })->name('kasir.pos');

    // Transaksi kasir
    Route::resource('transactions', TransactionController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Riwayat penjualan kasir
    Route::get('/kasir/sales', function () {
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)
            ->with('transactionItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kasir.sales', compact('transactions'));
    })->name('kasir.sales');
});

// Route untuk testing (hanya yang sudah login)
Route::middleware(['auth'])->group(function () {
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
});

// API Routes (dengan auth)
Route::middleware(['auth'])->group(function () {
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
});

// Route praktek Eloquent (hanya admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/praktek-eloquent', function () {
        // ... kode praktek eloquent yang sudah ada ...
        // (copy dari kode sebelumnya)
    });
});
