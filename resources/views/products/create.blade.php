@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Produk Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode"
                                name="barcode" value="{{ old('barcode') }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection