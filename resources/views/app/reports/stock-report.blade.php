<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Gudang</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1e3a8a; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .danger { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
           <h1 style="color: #2563eb; margin-bottom: 5px;">SMARTSTOCK</h1>
           <h3 style="margin: 0; color: #475569;">PT Maju Bersama Digital</h3>
           <p style="margin-top: 10px; color: #64748b;">Laporan Stok Inventaris Real-Time</p>
           <p><small>Dicetak pada: {{ date('d-m-Y H:i:s') }} WIB</small></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Sisa Stok</th>
                <th>Min. Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td class="text-right">{{ $product->stock }}</td>
                <td class="text-right {{ $product->stock <= $product->min_stock ? 'danger' : '' }}">
                    {{ $product->min_stock }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>