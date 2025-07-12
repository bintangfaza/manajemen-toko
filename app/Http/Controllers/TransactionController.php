<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $users = User::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Buat kode transaksi unik
            $transactionCode = 'TRX' . date('Ymd') . str_pad(Transaction::count() + 1, 4, '0', STR_PAD_LEFT);

            $totalAmount = 0;
            $transactionItems = [];

            // Hitung total dan siapkan data item
            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['id']);
                $itemTotal = $product->price * $productData['quantity'];
                $totalAmount += $itemTotal;

                $transactionItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $product->price,
                    'total' => $itemTotal,
                ];
            }

            // Buat transaksi
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'transaction_code' => $transactionCode,
                'total_amount' => $totalAmount,
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => $validated['paid_amount'] - $totalAmount,
            ]);

            // Buat item transaksi
            foreach ($transactionItems as $item) {
                $item['transaction_id'] = $transaction->id;
                TransactionItem::create($item);

                // Update stok produk
                Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('transactionItems.product', 'user');
        return view('transactions.show', compact('transaction'));
    }
}