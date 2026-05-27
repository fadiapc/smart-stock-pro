@extends('layouts.app')

@section('title', 'Dashboard Real-Time')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-slate-900 border border-slate-700 p-5 rounded-xl shadow-md flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">CPU Usage</p>
            <h3 id="stat-cpu" class="text-2xl font-black text-emerald-400">--%</h3>
        </div>
        <i class="fas fa-microchip text-4xl text-slate-700"></i>
    </div>

    <div class="bg-slate-900 border border-slate-700 p-5 rounded-xl shadow-md flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Memory Usage</p>
            <h3 id="stat-memory" class="text-2xl font-black text-blue-400">-- MB</h3>
        </div>
        <i class="fas fa-memory text-4xl text-slate-700"></i>
    </div>

    <div class="bg-slate-900 border border-slate-700 p-5 rounded-xl shadow-md flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Response Time</p>
            <h3 id="stat-response" class="text-2xl font-black text-purple-400">-- ms</h3>
        </div>
        <i class="fas fa-network-wired text-4xl text-slate-700"></i>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-boxes text-blue-500"></i> Stok Saat Ini
            </h2>
            <a href="{{ route('inventory.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition-colors">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </a>
        </div>
        
        <div id="product-list" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
            @foreach($products as $product)
                <div class="border border-slate-100 bg-slate-50 p-4 rounded-lg flex justify-between items-center hover:shadow-md transition-shadow" data-product-id="{{ $product->id }}">
                    <div>
                        <h3 class="font-bold text-slate-700">{{ $product->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">
                            <span class="bg-slate-200 px-2 py-1 rounded-md">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                        </p>
                        @if($product->stock <= $product->min_stock)
                            <p class="text-xs text-red-500 mt-2 font-semibold animate-pulse">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Stok Menipis! (Min: {{ $product->min_stock }})
                            </p>
                        @else
                            <p class="text-xs text-slate-400 mt-2 font-medium">
                                <i class="fas fa-info-circle mr-1"></i> Min Stok: {{ $product->min_stock }}
                            </p>
                        @endif
                    </div>
                    <div class="flex flex-col items-end gap-3">
                        <span id="stock-{{ $product->id }}" class="text-2xl font-black text-emerald-600">
                            {{ $product->stock }} <span class="text-sm font-normal text-slate-500">unit</span>
                        </span>
                        <button class="sell-trigger bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors"
                                data-product-id="{{ $product->id }}" data-quantity="5">
                            <i class="fas fa-shopping-cart mr-1"></i> Jual 5
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col">
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-bar text-blue-500"></i> Statistik Stok Inventaris
        </h2>
        <div class="relative flex-1 w-full min-h-[400px]">
            <canvas id="stockChart"></canvas>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col">
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-history text-blue-500"></i> Log Aktivitas Real-Time
        </h2>
        
        <div class="bg-slate-900 rounded-lg p-4 h-64 overflow-hidden relative">
            <div id="realtime-log" class="h-full overflow-y-auto font-mono text-sm space-y-2 pr-2">
                <p class="text-slate-500 italic flex items-center gap-2">
                    <i class="fas fa-spinner fa-spin"></i> Menunggu aktivitas terbaru...
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-map-marked-alt text-blue-500"></i> Peta Lokasi Gudang
        </h2>
        <div id="warehouse-map" class="h-96 w-full rounded-lg border border-slate-300 z-0"></div>
    </div>

    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-user-shield text-blue-500"></i> Riwayat Aktivitas Sistem (Audit Log)
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Aktivitas</th>
                        <th class="px-4 py-3">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($auditLogs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }} WIB</td>
                        <td class="px-4 py-3 font-semibold text-slate-700">{{ $log->user_name ?? 'Sistem' }}</td>
                        <td class="px-4 py-3 text-blue-600">{{ $log->action }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-slate-400 italic">Belum ada aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    function updateNotification(product) {
    const notifCount = document.getElementById('notif-count');
    const notifList = document.getElementById('notif-list');

    // Jika stok <= min_stock, tambahkan ke lonceng
    if (product.stock <= product.min_stock) {
        notifCount.classList.remove('hidden');
        
        // Cek apakah notif sudah ada, kalau belum tambahkan
        if (notifList.innerHTML.includes('Tidak ada')) notifList.innerHTML = '';
        
        if (!notifList.innerHTML.includes('id-notif-' + product.id)) {
            notifList.innerHTML += `
                <div id="id-notif-${product.id}" class="p-2 border-b border-slate-50 text-xs hover:bg-slate-50">
                    <p class="font-bold text-red-600">${product.name}</p>
                    <p class="text-slate-500">Sisa: ${product.stock} (Min: ${product.min_stock})</p>
                </div>
            `;
            }
        }
    }
        // --- PANEL MONITORING SERVER ---
        function fetchServerStats() {
            fetch('/app/server-stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('stat-cpu').innerText = data.cpu;
                    document.getElementById('stat-memory').innerText = data.memory;
                    document.getElementById('stat-response').innerText = data.response_time;
                })
                .catch(error => console.error('Gagal mengambil data server', error));
        }
        
        fetchServerStats(); 
        setInterval(fetchServerStats, 3000);

        // --- INISIALISASI CHART.JS ---
        const productsData = @json($products);
        
        const chartLabels = productsData.map(p => p.name);
        const chartStock = productsData.map(p => p.stock);
        const chartMinStock = productsData.map(p => p.min_stock);

        const ctx = document.getElementById('stockChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Sisa Stok',
                        data: chartStock,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderRadius: 6,
                    },
                    {
                        label: 'Batas Minimum',
                        data: chartMinStock,
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // --- INISIALISASI PETA LEAFLET ---
        const map = L.map('warehouse-map').setView([-6.2828, 106.6648], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const warehouses = [
            { name: "Gudang Utama BSD", lat: -6.2828, lng: 106.6648, capacity: "10.000 Unit" },
            { name: "Gudang Cabang Bogor", lat: -6.5950, lng: 106.8166, capacity: "5.000 Unit" },
            { name: "Gudang Transit Sentul", lat: -6.5686, lng: 106.8623, capacity: "3.500 Unit" }
        ];

        warehouses.forEach(warehouse => {
            const marker = L.marker([warehouse.lat, warehouse.lng]).addTo(map);
            marker.bindPopup(`<b>${warehouse.name}</b><br>Kapasitas: ${warehouse.capacity}`);
        });

        setTimeout(function(){ map.invalidateSize()}, 500);

        // --- LOGIKA TOMBOL JUAL ---
        document.querySelectorAll('.sell-trigger').forEach(function(button) {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const quantity = this.getAttribute('data-quantity');

                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;

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
                    this.innerHTML = originalText;
                    this.disabled = false;

                    if (data.success) {
                        updateNotification(data.product);
                        
                        const stockEl = document.getElementById('stock-' + productId);
                        stockEl.innerHTML = `${data.product.stock} <span class="text-sm font-normal text-slate-500">unit</span>`;
                        stockEl.classList.add('text-orange-500');
                        setTimeout(() => stockEl.classList.remove('text-orange-500'), 1000);

                        const log = document.getElementById('realtime-log');
                        const now = new Date();
                        const timeString = now.toLocaleTimeString('id-ID');
                        
                        if(log.innerHTML.includes('Menunggu aktivitas terbaru')) {
                            log.innerHTML = '';
                        }

                        log.innerHTML = 
                            `<div class="border-l-2 border-blue-500 pl-3 py-1 mb-2">
                                <span class="text-slate-400">[${timeString}]</span>
                                <span class="text-blue-400 font-bold ml-2">LOCAL</span>
                                <span class="text-slate-300 ml-2">Produk ID ${productId} terjual ${quantity} unit. Sisa: ${data.product.stock}</span>
                            </div>` + log.innerHTML;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    console.error(error);
                    alert('Transaksi gagal menghubungi server.');
                });
            });
        });

        // --- LOGIKA LARAVEL ECHO (REAL-TIME) ---
        if (typeof Echo !== 'undefined') {
            Echo.channel('inventory-channel')
                .listen('StockUpdated', function(data) {
                    const stockElement = document.getElementById('stock-' + data.product_id);
                    if (stockElement) {
                        stockElement.innerHTML = `${data.new_stock} <span class="text-sm font-normal text-slate-500">unit</span>`;
                    }

                    const log = document.getElementById('realtime-log');
                    
                    if(log.innerHTML.includes('Menunggu aktivitas terbaru')) {
                        log.innerHTML = '';
                    }

                    log.innerHTML = 
                        `<div class="border-l-2 border-emerald-500 pl-3 py-1 mb-2">
                            <span class="text-slate-400">[${data.timestamp.split(' ')[1]}]</span>
                            <span class="text-emerald-400 font-bold ml-2">BROADCAST</span>
                            <span class="text-slate-300 ml-2">Produk ID ${data.product_id} terjual ${data.sold_quantity} unit. Sisa: ${data.new_stock}</span>
                        </div>` + log.innerHTML;
                });
        }
    });
</script>
@endsection