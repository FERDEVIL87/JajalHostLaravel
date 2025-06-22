<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
        ]);

        $transaction_id = 'TRX-' . strtoupper(Str::random(10));
        
        foreach ($validated['items'] as $item) {
            Checkout::create([
                'transaction_id' => $transaction_id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['quantity'] * $item['price'],
                'customer_name' => $validated['customer_name'],
                'customer_address' => $validated['customer_address'],
                'customer_phone' => $validated['customer_phone'],
                'purchase_date' => now(),
                'status_order' => 'Belum Dikonfirmasi', // <-- STATUS AWAL
            ]);
        }

        return response()->json([
            'message' => 'Pesanan berhasil diterima!',
            'transaction_id' => $transaction_id,
        ], 201);
    }

    public function status(Request $request) {
        // 1. Ubah validasi dari 'email' menjadi 'customer_name'
        $request->validate(['customer_name' => 'required|string']);

        // 2. Ubah query 'where' untuk mencari berdasarkan 'customer_name'
        $orders = Checkout::where('customer_name', $request->customer_name)
                          ->orderBy('purchase_date', 'desc')
                          ->get()
                          ->groupBy('transaction_id');

        return response()->json($orders);
    }
}
