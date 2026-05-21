@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard Stok Inventaris Real-Time</h1>

    <div id="product-stock-display" class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl mb-4">Stok Saat Ini</h2>
        <div id="product-list">
            @foreach($products as $product)
                <div class="border p-4 mb-3 flex justify-between rounded" data-product-id="{{ $product->id }}">
                    <div>
                        <h3 class="font-semibold">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">Kategori: {{ $product->category->name ?? '-' }}</p>
                        <p class="text-sm text-gray-500">Minimum stok: {{ $product->min_stock }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span id="stock-{{ $product->id }}" class="text-2xl font-bold text-green-700">
                            {{ $product->stock }} unit
                        </span>
                        <button class="sell-trigger bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                                data-product-id="{{ $product->id }}" data-quantity="5">
                            Jual 5 Unit
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-yellow-50 p-6 rounded-lg shadow">
        <h2 class="text-2xl mb-4">Log Perubahan Real-Time</h2>
        <div id="realtime-log" class="border p-4 bg-white h-96 overflow-y-auto">
            <p class="text-gray-400">Menunggu pembaruan dari server...</p>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.sell-trigger').forEach(function(button) {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const quantity = this.getAttribute('data-quantity');

                console.log('productId:', productId);
                console.log('quantity:', quantity);

                fetch('/inventory/sell', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    if (data.success) {
                        document.getElementById('stock-' + productId).innerText =
                            data.product.stock + ' unit';

                        const log = document.getElementById('realtime-log');
                        const now = new Date();
                        const timestamp =
                            now.getFullYear() + '-' +
                            String(now.getMonth() + 1).padStart(2, '0') + '-' +
                            String(now.getDate()).padStart(2, '0') + ' ' +
                            String(now.getHours()).padStart(2, '0') + ':' +
                            String(now.getMinutes()).padStart(2, '0') + ':' +
                            String(now.getSeconds()).padStart(2, '0');

                        log.innerHTML =
                            `<p>
                                <span class="text-gray-500">[${timestamp}]</span>
                                [LOCAL] Produk #${productId} terjual ${quantity} unit.
                                Sisa stok: ${data.product.stock} unit
                            </p>` +
                            log.innerHTML;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Transaksi gagal. Cek console browser.');
                });
            });
        });

        if (typeof Echo !== 'undefined') {
            Echo.channel('inventory-channel')
                .listen('StockUpdated', function(data) {
                    const stockElement = document.getElementById('stock-' + data.product_id);

                    if (stockElement) {
                        stockElement.innerText = data.new_stock + ' unit';
                    }

                    const log = document.getElementById('realtime-log');
                    log.innerHTML =
                        `<p>[REAL-TIME] ${data.timestamp} | Produk #${data.product_id} terjual ${data.sold_quantity} unit. Sisa stok: ${data.new_stock} unit</p>` +
                        log.innerHTML;
                });
        } else {
            console.warn('Laravel Echo belum aktif.');
        }
    });
</script>
@endsection