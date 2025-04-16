<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Enums\OrderStatus;

class IndexController extends Controller
{
    public function indexHome()
    {
        $title = 'Home';
        return view('buyer.pages.home.index', compact('title'));
    }

    public function indexCatalogue()
    {
        $title = 'Catalogue';
        return view('buyer.pages.catalogue.index', compact('title'));
    }

    public function detailCatalogue()
    {
        $title = 'Catalogue';
        return view('buyer.pages.catalogue.detail', compact('title'));
    }

    public function indexCustomDesign()
    {
        $title = 'Custom Design';
        return view('buyer.pages.customdesign.index', compact('title'));
    }

    public function detailCustomDesign()
    {
        $title = 'Custom Design';
        return view('buyer.pages.customdesign.detail', compact('title'));
    }

    public function indexOrderPO()
    {
        $title = 'PO - Order';
        return view('buyer.pages.po.index', compact('title'));
    }

    public function indexOrder()
    {
        $title = 'Order';
        return view('buyer.pages.order.index', compact('title'));
    }

    public function detailOrder($id)
    {
        $order = Order::with([
            'orderTracking.trackingStep' => function ($query) {
                $query->orderBy('step_order', 'asc');
            },
            'katalog',
            'user',
            'file'
        ])
            ->where('id', $id) // Cari order berdasarkan ID
            ->where('id_user', auth()->id()) // Hanya yang sesuai dengan user login
            ->first(); // Ambil hasil pertama

        // Jika order tidak ditemukan (bukan milik user), maka tampilkan Forbidden
        if (!$order) {
            abort(403, 'Unauthorized access');
        }

        $orderDetails = [
            'material' => $order->id_katalog === null ? $order->material : ($order->katalog->material ?? null),
            'length' => $order->id_katalog === null ? $order->length : ($order->katalog->length ?? null),
            'width' => $order->id_katalog === null ? $order->width : ($order->katalog->width ?? null),
            'height' => $order->id_katalog === null ? $order->height : ($order->katalog->height ?? null),
            'weight' => $order->id_katalog === null ? $order->weight : ($order->katalog->weight ?? null),
            'unit' => $order->id_katalog === null ? $order->unit : ($order->katalog->unit ?? null),
            'desc' => $order->id_katalog === null ? $order->desc : ($order->katalog->desc ?? null)
        ];

        return view('buyer.pages.order.detail', compact('order', 'orderDetails'));
    }
}
