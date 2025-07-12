@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Transaksi</h4>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Transaksi</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Kode Transaksi:</strong></td>
                                    <td>{{ $transaction->transaction_code }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kasir:</strong></td>
                                    <td>{{ $transaction->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Ringkasan Pembayaran</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Total:</strong></td>
                                    <td>Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibayar:</strong></td>
                                    <td>Rp. {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kembalian:</strong></td>
                                    <td>Rp. {{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h5>Detail Item</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->transactionItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection