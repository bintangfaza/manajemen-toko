@extends('layouts.app')

@section('title', 'Buat Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Buat Transaksi Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Kasir</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" name="user_id" required>
                                <option value="">Pilih Kasir</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Produk</label>
                            <div id="productList">
                                <div class="product-item row align-items-center mb-2">
                                    <div class="col-md-6">
                                        <select class="form-control" name="products[0][id]" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                    {{ $product->name }} - Rp. {{ number_format($product->price) }} (Stok:
                                                    {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" name="products[0][quantity]"
                                            placeholder="Jumlah" min="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger"
                                            onclick="removeProduct(this)">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="addProduct()">Tambah Produk</button>
                        </div>

                        <div class="mb-3">
                            <label for="paid_amount" class="form-label">Jumlah Bayar</label>
                            <input type="number" class="form-control @error('paid_amount') is-invalid @enderror"
                                id="paid_amount" name="paid_amount" value="{{ old('paid_amount') }}" min="0" step="0.01"
                                required>
                            @error('paid_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Buat Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let productIndex = 1;

        function addProduct() {
            const productList = document.getElementById('productList');
            const productItem = document.createElement('div');
            productItem.className = 'product-item row align-items-center mb-2';
            productItem.innerHTML = `
            <div class="col-md-6">
                <select class="form-control" name="products[${productIndex}][id]" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - Rp. {{ number_format($product->price) }} (Stok: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="products[${productIndex}][quantity]" 
                       placeholder="Jumlah" min="1" required>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger" onclick="removeProduct(this)">Hapus</button>
            </div>
        `;
            productList.appendChild(productItem);
            productIndex++;
        }

        function removeProduct(button) {
            const productItems = document.querySelectorAll('.product-item');
            if (productItems.length > 1) {
                button.closest('.product-item').remove();
            }
        }
    </script>
@endsection