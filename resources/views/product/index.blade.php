@extends('layouts.app')
@section('content_title', 'Data Produk')
@section('content')
    <div class="card-title">
        <h4 class="card-header">Data Product</h4>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-2">
            <x-product.form-product />
        </div>
        <x-alert :errors="$errors" />
        <table class="table table-sm" id="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->nama_produk }}</td>
                        <td>Rp {{ number_format($product->harga) }}</td>
                        <td>{{ number_format($product->stok) }}</td>
                        <td>
                            <div class="d-flex align-items-center">

                                {{-- Tombol Edit --}}
                                <x-product.form-product :id="$product->id" />

                                {{-- Tombol Hapus (admin saja) --}}
                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('master-data.product.destroy', $product->id) }}"
                                        class="text-danger mx-1" data-confirm-delete="true">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @endif

                                {{-- Tombol Order (Sales) --}}
                                @if (auth()->user()->role == 'sales')
                                    <form action="{{ route('product.order', $product->id) }}" method="POST"
                                        class="d-inline mx-1">
                                        @csrf
                                        <button class="btn btn-sm btn-primary">
                                            Order
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Approve (Admin) --}}
                                @if (auth()->user()->role == 'admin' && $product->pending_orders > 0)
                                    <form action="{{ route('product.approve', $product->id) }}" method="POST"
                                        class="d-inline mx-1">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            Approve ({{ $product->pending_orders }})
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
