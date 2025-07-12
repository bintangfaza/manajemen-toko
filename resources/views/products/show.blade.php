@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Produk</h4>
                    <div>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Harga:</strong></td>
                                    <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Stok:</strong></td>
                                    <td>
                                        <span
                                            class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $product->stock }} unit
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Barcode:</strong></td>
                                    <td>{{ $product->barcode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat:</strong></td>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diperbarui:</strong></td>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection