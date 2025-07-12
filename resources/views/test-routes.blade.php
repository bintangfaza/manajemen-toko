<!DOCTYPE html>
<html>

<head>
    <title>Test Routes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .route-item {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .method {
            font-weight: bold;
            color: #007bff;
        }

        .url {
            font-family: monospace;
            background: #f8f9fa;
            padding: 2px 4px;
        }
    </style>
</head>

<body>
    <h1>Daftar Routes dalam Aplikasi</h1>

    <h2>Resource Routes untuk Products</h2>
    @foreach($routes as $method => $url)
        <div class="route-item">
            <span class="method">{{ $method }}</span><br>
            <span class="url">{{ $url }}</span>
        </div>
    @endforeach

    <h2>Route Links untuk Testing</h2>
    <ul>
        <li><a href="{{ route('products.index') }}">Lihat Semua Produk</a></li>
        <li><a href="{{ route('products.create') }}">Tambah Produk Baru</a></li>
        <li><a href="{{ route('transactions.index') }}">Lihat Transaksi</a></li>
        <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li><a href="{{ route('admin.reports') }}">Admin Reports</a></li>
        <li><a href="{{ route('api.products.index') }}">API Products (JSON)</a></li>
    </ul>
</body>

</html>