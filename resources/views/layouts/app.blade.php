<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartStock Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style> [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden font-['Poppins']">

    <aside class="w-64 bg-slate-900 text-white flex flex-col transition-all duration-300">
        <div class="p-6 border-b border-slate-800 flex flex-col justify-center">
            <h1 class="text-xl font-bold tracking-wider text-blue-400">SMART<span class="text-white">STOCK PRO</span></h1>
            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">PT Maju Bersama Digital</p>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="/app/inventory" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ Request::is('app/inventory') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white transition-colors' }}">
                <i class="fas fa-chart-pie w-5"></i> Dashboard
            </a>
            
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Manajemen Data</p>
            </div>
            
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ Request::is('app/products*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white transition-colors' }}">
                <i class="fas fa-box w-5"></i> Produk
            </a>
            
            <a href="{{ route('warehouses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ Request::is('app/warehouses*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white transition-colors' }}">
                <i class="fas fa-warehouse w-5"></i> Gudang
            </a>
            
            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ Request::is('app/suppliers*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white transition-colors' }}">
                <i class="fas fa-truck-loading w-5"></i> Supplier
            </a>
            
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ Request::is('app/transactions*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white transition-colors' }}">
                <i class="fas fa-exchange-alt w-5"></i> Transaksi
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaturan</p>
            </div>

            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ Request::is('app/users*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white transition-colors' }}">
                <i class="fas fa-users w-5"></i> Manajemen User
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-lg text-red-400 hover:bg-red-500/10 transition-colors text-left">
                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="bg-white shadow-sm border-b border-slate-200 px-8 py-4 flex justify-between items-center z-10">
            <h2 class="text-xl font-semibold text-slate-800">@yield('title', 'Dashboard')</h2>
            
            <div class="flex items-center gap-6">
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-slate-500 hover:text-blue-600 transition-colors p-2 relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span id="notif-count" class="absolute top-0 right-0 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold hidden">!</span>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak 
                         class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-lg border border-slate-100 p-2 z-50">
                        <h3 class="text-xs font-bold text-slate-400 uppercase p-2">NOTIFIKASI STOK</h3>
                        <div id="notif-list" class="max-h-64 overflow-y-auto">
                            <p class="text-sm text-slate-500 p-2 italic">Tidak ada peringatan baru.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 border-l pl-6">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-auto p-8">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>
</html>