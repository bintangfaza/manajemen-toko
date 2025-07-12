@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Transaksi</h1>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Buat Transaksi</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Dibayar</th>
                                <th>Kembalian</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_code }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction) }}"
                                            class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted">Belum ada transaksi.</p>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">Buat Transaksi Pertama</a>
                </div>
            @endif
        </div>
    </div>
@endsection