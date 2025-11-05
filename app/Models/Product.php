<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'nama_produk',
        'harga',
        'stok'
    ];

    public static function nomorSku(){
        // SKU-0001
        $prefix = 'SKU-';
        $maxId = self::max('id');
        $sku = $prefix . str_pad($maxId + 1 , 5, '0', STR_PAD_LEFT);
        return $sku;
    }
}
