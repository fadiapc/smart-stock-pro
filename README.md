# Laravel Inventory Real-Time - BNSP Website Developer Modul 2

Template rancangan aplikasi Laravel untuk memenuhi kebutuhan Modul 2: Pengembangan Aplikasi & Manajemen Data.

## Fitur utama
- MVC Laravel: Model, View, Controller
- Database relasional: products, categories, stock, users, stock_transactions
- CRUD produk dan stok
- Transaksi penjualan dengan validasi, transaction, lockForUpdate, rollback
- Query laporan stok kritis menggunakan JOIN, GROUP BY, HAVING
- Broadcasting event StockUpdated via Laravel Echo/Pusher
- Dashboard real-time tanpa refresh
- Queue job untuk laporan stok

## Instalasi ringkas
```bash
composer create-project laravel/laravel inventory-realtime
cd inventory-realtime
```
Salin folder/file dari template ini ke project Laravel Anda, lalu jalankan:
```bash
composer require pusher/pusher-php-server
npm install laravel-echo pusher-js jquery
php artisan migrate --seed
php artisan serve
npm run dev
```

## ENV broadcasting contoh
```env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=ap1
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```
