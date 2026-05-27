<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
    $transactions = \App\Models\StockTransaction::with('product')->latest()->paginate(15);
    return view('app.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
    $products = \App\Models\Product::all();
    return view('app.transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'type' => 'required|in:in,out', // 'in' untuk masuk, 'out' untuk keluar
            'quantity' => 'required|numeric',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);
        
        // Hitung stok baru
        $newStock = ($request->type == 'in') 
                    ? $product->stock + $request->quantity 
                    : $product->stock - $request->quantity;

        // Simpan Transaksi
        \App\Models\StockTransaction::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(), // Mencatat user yang sedang login
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'stock_after'=> $newStock,
        ]);

        // Update Stok Produk Utama
        $product->update(['stock' => $newStock]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
