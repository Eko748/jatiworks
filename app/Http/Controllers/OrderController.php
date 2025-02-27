<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Katalog;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'Orders',
        ];
    }
    public function index()
    {
        $title = $this->title[0];
        $user = User::where('id_role', 2)->get();
        $katalog = Katalog::all();

        return view('admin.order.index', compact('title', 'user', 'katalog'));
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
                $query->orWhereRaw("LOWER(code_order) LIKE ?", ["%$searchTerm%"]);
                $query->orWhereHas('katalog', function ($subquery) use ($searchTerm) {
                    $subquery->whereRaw("LOWER(item_name) LIKE ?", ["%$searchTerm%"]);
                });
                $query->orWhereHas('user', function ($subquery) use ($searchTerm) {
                    $subquery->whereRaw("LOWER(name) LIKE ?", ["%$searchTerm%"]);
                });
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
                    'code_order' => $item->code_order,
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
                    'detail_url' => route('admin.order.detail', $item->id),
                    'file'       => $item->file->map(function ($file) {
                        return [
                            'id'        => $file->id,
                            'file_name' => $file->file_name,
                        ];
                    })
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

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->filled('id_katalog')) {
                $request->validate([
                    'id_user'   => 'required|integer',
                    'id_katalog' => 'required|integer|exists:katalog,id',
                    'qty'       => 'required|integer|min:1',
                    'price'     => 'required|numeric|min:0'
                ]);

                $order = Order::create([
                    'id_user'   => $request->id_user,
                    'id_katalog' => $request->id_katalog,
                    'qty'       => $request->qty,
                    'price'     => $request->price
                ]);
            } else {
                $request->validate([
                    'id_user'   => 'required|integer',
                    'item_name' => 'required|string|max:255',
                    'material'  => 'nullable|string|max:255',
                    'length'    => 'nullable|numeric',
                    'width'     => 'nullable|numeric',
                    'height'    => 'nullable|numeric',
                    'weight'    => 'nullable|string',
                    'desc'      => 'nullable|string',
                    'unit'      => 'nullable|string',
                    'qty'       => 'required|integer|min:1',
                    'price'     => 'required|numeric|min:0',
                    'file'      => 'nullable|array',
                    'file.*'    => 'file|mimes:jpg,jpeg,png|max:2048'
                ]);

                $order = Order::create([
                    'id_user'   => $request->id_user,
                    'item_name' => $request->item_name,
                    'material'  => $request->material,
                    'length'    => $request->length,
                    'width'     => $request->width,
                    'height'    => $request->height,
                    'weight'    => $request->weight,
                    'desc'      => $request->desc,
                    'unit'      => $request->unit,
                    'qty'       => $request->qty,
                    'price'     => $request->price
                ]);

                if ($request->hasFile('file')) {
                    foreach ($request->file('file') as $file) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs('uploads/order', $filename, 'public');

                        File::create([
                            'id_order' => $order->id,
                            'file_name' => $filename
                        ]);
                    }
                }
            }

            $id_order_str = (string) $order->id;
            $id_user_str = (string) $request->id_user;
            $total_length = strlen($id_order_str) + strlen($id_user_str);

            $random_length = max(0, 6 - $total_length);
            $random_number = str_pad(mt_rand(0, pow(10, $random_length) - 1), $random_length, '0', STR_PAD_LEFT);

            $order->update([
                'code_order' => "{$id_order_str}{$id_user_str}{$random_number}"
            ]);

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message'     => 'Order successfully created!',
                'data'        => $order->load('file')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status_code' => 500,
                'errors'      => true,
                'message'     => 'Something went wrong!',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $request->validate([
                'status' => ['required', 'in:WP,NC,PC']
            ]);

            $order->status = OrderStatus::from($request->status);
            $order->save();

            return response()->json([
                'status_code' => 200,
                'message'     => 'Status updated successfully!',
                'data'        => [
                    'id'     => $order->id,
                    'status' => $order->status->label(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code'  => 500,
                'errors'       => true,
                'message'      => 'Something went wrong!',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
    public function detail($id)
    {
        $order = Order::with(['orderTracking.trackingStep' => function($query) {
            $query->orderBy('step_order', 'asc');
        }])->findOrFail($id);

        $title = 'Order Detail - ' . $order->code_order;

        return view('admin.order.detail', compact('title', 'order'));
    }
}
