<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'Data Catalogue',
        ];
    }
    public function index()
    {
        $title = $this->title[0];

        return view('admin.order.index', compact('title'));
    }

    public function getdataorder(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = Order::with(['katalog', 'user'])->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->where(function ($query) use ($searchTerm) {
                $query->orWhereRaw("LOWER(item_name) LIKE ?", ["%$searchTerm%"]);
            });
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $query->whereBetween('id', [$start_date, $end_date]);
        }

        $data = $query->paginate($meta['limit']);

        if ($data->isEmpty()) {
            return response()->json([
                'status_code' => 400,
                'errors' => true,
                'message' => 'Tidak ada data'
            ], 400);
        }

        $mappedData = collect($data->items())->map(function ($item) {
            if ($item->id_katalog === null) {
                // Jika id_katalog null, tampilkan data dari tabel Order
                return [
                    'id' => $item->id,
                    'buyer_name' => $item->user->name ?? null,
                    'item_name' => $item->item_name,
                    'material' => $item->material,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'status' => $item->status,
                ];
            } elseif ($item->id_katalog !== null && empty($item->item_name) && empty($item->material) && empty($item->qty)) {
                // Jika id_katalog ada dan data Order lainnya null, tampilkan data dari tabel Katalog
                return [
                    'id' => $item->id,
                    'item_name' => $item->katalog->item_name ?? null,
                    'material' => $item->katalog->material ?? null,
                    'length' => $item->katalog->length ?? null,
                    'width' => $item->katalog->width ?? null,
                    'height' => $item->katalog->height ?? null,
                    'weight' => $item->katalog->weight ?? null,
                    'unit' => $item->katalog->unit ?? null,
                    'desc' => $item->katalog->desc ?? null,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'status' => $item->status,
                ];
            } else {
                // Jika id_katalog ada tetapi data Order tidak null, tetap tampilkan data Order
                return [
                    'id' => $item->id,
                    'buyer_name' => $item->user->name ?? null,
                    'item_name' => $item->item_name,
                    'material' => $item->material,
                    'length' => $item->length ?? null,
                    'width' => $item->width ?? null,
                    'height' => $item->height ?? null,
                    'weight' => $item->weight ?? null,
                    'unit' => $item->unit ?? null,
                    'desc' => $item->desc ?? null,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'status' => $item->status,
                ];
            }
        });

        return response()->json([
            'data' => $mappedData,
            'status_code' => 200,
            'errors' => false,
            'message' => 'Sukses',
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage()
            ]
        ], 200);
    }
}
