<?php

namespace App\View\Components\Product;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $nama_product, $harga, $stok, $is_active;
    public function __construct($id = null)
    {
        if ($id) {
            $product = Product::find($id);

            $this->id = $product->id;
            $this->nama_product = $product->nama_produk;
            $this->harga = $product->harga;
            $this->stok = $product->stok;
            $this->is_active = $product->is_active;
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.form-product');
    }
}
