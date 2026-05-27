<?php

namespace App\Http\Controllers;

use App\Events\StockUpdated;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryController extends Controller
{

    public function dashboard()
    {
        $products = \App\Models\Product::with('category')->get();
        
        // Ambil 10 log aktivitas terbaru
        $auditLogs = \App\Models\AuditLog::latest()->take(10)->get();
            return view('app.inventory', compact('products', 'auditLogs'));
    }

    public function recordSale(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        try {
            $product = DB::transaction(function () use ($validated) {
                $product = Product::query()
                    ->lockForUpdate()
                    ->findOrFail($validated['product_id']);

                if ($product->stock < $validated['quantity']) {
                    return null;
                }

                $product->stock = $product->stock - $validated['quantity'];
                $product->save();

                StockTransaction::create([
                    'product_id' => $product->id,
                    'user_id' => $validated['user_id'] ?? null,
                    'type' => 'SALE',
                    'quantity' => $validated['quantity'],
                    'stock_after' => $product->stock,
                ]);

                return $product;
            });

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi.',
                ], 422);
            }

            // Aktifkan kembali nanti setelah AJAX sudah berhasil
            // broadcast(new StockUpdated(
            //     productId: $product->id,
            //     newStock: $product->stock,
            //     quantitySold: $validated['quantity'],
            //     productName: $product->name,
            // ))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'product' => $product,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function exportPdf()
    {
    // Mengambil data produk dan mengurutkannya
    $products = Product::with('category')->orderBy('name')->get();

    // Meload file tampilan PDF dan mengirimkan datanya
    $pdf = Pdf::loadView('app.reports.stock-report', compact('products'));

    // Mengunduh file PDF dengan nama spesifik
    return $pdf->download('Laporan_Stok_SmartStock_Pro.pdf');
    }

    public function criticalStock(): JsonResponse
    {
        $data = Product::query()
            ->select(
                'products.id',
                'products.name as nama_produk',
                'products.min_stock as batas_minimum'
            )
            ->selectRaw('products.stock as total_stok_aktual')
            ->whereColumn('products.stock', '<', 'products.min_stock')
            ->orderBy('products.stock')
            ->get();

        return response()->json($data);
    }

    public function serverStats()
    {
        $startTime = microtime(true);
        
        // 1. Simulasi CPU (Karena sys_getloadavg tidak jalan di Windows/Laragon)
        // Kita buat angka acak fluktuatif antara 5% sampai 15% (khas server idle)
        $cpuUsage = rand(5, 15) . '%'; 
        
        // 2. Baca Penggunaan Memori PHP secara Real
        $memory = round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB';
        
        // 3. Hitung Waktu Respons (Response Time)
        $responseTime = round((microtime(true) - $startTime) * 1000) . ' ms';

        return response()->json([
            'cpu' => $cpuUsage,
            'memory' => $memory,
            'response_time' => $responseTime
        ]);
    }
}