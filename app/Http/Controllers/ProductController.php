<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            $product->pending_orders = DB::table('orders')
                ->where('product_id', $product->id)
                ->where('status', 'pending')
                ->count();
            return $product;
        });;
        confirmDelete('Hapus Data', 'Apakah anda yakin ingin menghapus data ini?');
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        // Ambil id dari request (jika ada)
        $id = $request->id;

        $request->validate([
            'nama_product' => 'required|unique:products,nama_produk,' . $id,
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|numeric|min:0',
        ], [
            'nama_product.required' => 'Nama produk harus diisi',
            'nama_product.unique'   => 'Nama produk sudah ada',
            'harga.required'        => 'Harga harus diisi',
            'harga.numeric'         => 'Harga harus berupa angka',
            'harga.min'             => 'Harga minimal 0',
            'stok.required'         => 'Stok harus diisi',
            'stok.numeric'          => 'Stok harus berupa angka',
        ]);

        $newRequest = [
            'nama_produk' => $request->nama_product,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ];

        if (!$id) {
            $newRequest['sku'] = Product::nomorSku();
        }

        Product::updateOrCreate(
            ['id' => $id],
            $newRequest
        );

        toast()->success('Data berhasil disimpan');
        return redirect()->route('master-data.product.index');
        // dd($request->all());
    }

    public function order($id)
    {
        $product = Product::findOrFail($id);

        // Jangan kurangi stok di sini dulu!
        DB::table('orders')->insert([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        toast()->success('Order berhasil dikirim, menunggu approval admin');
        return back();
    }

    public function approve($id)
    {
        $order = DB::table('orders')->where('id', $id)->first();

        if (!$order || $order->status !== 'pending') {
            toast()->error('Order tidak valid');
            return back();
        }

        $product = Product::findOrFail($order->product_id);

        // Kurangi stok sebenarnya
        $product->stok = $product->stok - 1;
        $product->save();

        DB::table('orders')->where('id', $id)->update([
            'status' => 'approved',
            'updated_at' => now()
        ]);

        toast()->success('Order di-approve, stok berkurang 1');
        return back();
    }

    public function destroy(String $id)
    {
        $product = Product::find($id);
        $product->delete();
        toast()->success('Data berhasil dihapus');
        return redirect()->route('master-data.product.index');
    }
}
