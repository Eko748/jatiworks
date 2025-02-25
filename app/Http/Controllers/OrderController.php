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
            $query->whereBetween('created_at', [$start_date, $end_date]);
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
            return [
                'id' => $item->id,
                'buyer_name' => $item->user->name ?? null,
                'item_name' => $item->id_katalog === null ? $item->item_name : ($item->katalog->item_name ?? null),
                'material' => $item->id_katalog === null ? $item->material : ($item->katalog->material ?? null),
                'length' => $item->id_katalog === null ? $item->length : ($item->katalog->length ?? null),
                'width' => $item->id_katalog === null ? $item->width : ($item->katalog->width ?? null),
                'height' => $item->id_katalog === null ? $item->height : ($item->katalog->height ?? null),
                'weight' => $item->id_katalog === null ? $item->weight : ($item->katalog->weight ?? null),
                'unit' => $item->id_katalog === null ? $item->unit : ($item->katalog->unit ?? null),
                'desc' => $item->id_katalog === null ? $item->desc : ($item->katalog->desc ?? null),
                'qty' => $item->qty,
                'price' => $item->price,
                'status' => $item->status->label(),
            ];
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
