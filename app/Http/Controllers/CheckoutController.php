<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan checkout.
     */
    public function index()
    {
        $checkouts = Checkout::orderBy('purchase_date', 'desc')->get();
        
        // Diubah untuk mengelompokkan berdasarkan 'customer_name'
        $groupedByName = $checkouts->groupBy('customer_name');

        // Kirim variabel dengan nama baru agar lebih jelas
        return view('checkouts.index', compact('groupedByName'));
    }

        public function store(Request $request)
    {
        // Validasi data yang masuk dari Vue
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0', // <-- Validasi harga per item
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
        ]);

        // Buat satu ID transaksi unik untuk seluruh pesanan ini
        $transaction_id = 'TRX-' . strtoupper(Str::random(10));
        
        // Loop melalui setiap item di keranjang dan simpan sebagai baris terpisah
        foreach ($validated['items'] as $item) {
            Checkout::create([
                'transaction_id' => $transaction_id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'], // <-- Simpan harga satuan
                'total_price' => $item['quantity'] * $item['price'], // <-- Hitung dan simpan total harga
                'customer_name' => $validated['customer_name'],
                'customer_address' => $validated['customer_address'],
                'customer_phone' => $validated['customer_phone'],
                'purchase_date' => now(), // Otomatis isi tanggal sekarang
            ]);
        }

        // Kirim respons sukses kembali ke Vue
        return response()->json([
            'message' => 'Pesanan berhasil diterima!',
            'transaction_id' => $transaction_id,
        ], 201); // 201 Created
    }

    /**
     * Menghapus seluruh transaksi berdasarkan transaction_id.
     */
    public function destroy($transaction_id)
    {
        // Hapus semua baris yang memiliki transaction_id yang sama
        Checkout::where('transaction_id', $transaction_id)->delete();

        return redirect()->route('checkouts.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Metode baru untuk update status
     */
    public function updateStatus(Request $request, $transaction_id) {
        $request->validate([
            'status' => 'required|in:Sudah Dikonfirmasi,Sudah Dikirim,Selesai,Dibatalkan'
        ]);

        // Update semua item yang memiliki transaction_id yang sama
        Checkout::where('transaction_id', $transaction_id)
                ->update(['status_order' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}