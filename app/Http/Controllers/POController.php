<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Po;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class POController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'PO',
        ];
    }

    public function index()
    {
        $title = $this->title[0];
        $user = User::where('id_role', 2)->get();

        return view('admin.po.index', compact('title', 'user'));
    }

    public  function getdatapo(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = Po::with(['user'])->orderBy('id', $meta['orderBy']);

        if ($request->has('user_id')) {
            $query->where('id_user', $request->user_id);
        }

        if ($request->has('id_user')) {
            $query->where('id_user', $request->id_user);

            if (!$query->exists()) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'User ID not found',
                    'error'   => true,
                    'id_user' => false
                ], 400);
            }
        }

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->whereRaw("LOWER(kode_po) LIKE ?", ["%$searchTerm%"]);
        }

        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $query->whereBetween('id', [$startDate, $endDate]);
        }

        $data = $query->paginate($meta['limit']);

        $paginationMeta = [
            'total'        => $data->total(),
            'per_page'     => $data->perPage(),
            'current_page' => $data->currentPage(),
            'total_pages'  => $data->lastPage()
        ];

        $mappedData = $data->map(function ($item) {
            return [
                'id'         => $item->id,
                'id_encrypt' => Crypt::encryptString($item->id),
                'kode_po'  => $item->kode_po,
                'id_user'  => $item->user->id,
                'buyer_name'  => $item->user->name,
                'file'  => $item->file,
                'desc'  => $item->desc,
                'dp'  => $item->dp,
                'status' => OrderStatus::from($item->status)->label()
            ];
        });

        if ($mappedData->isEmpty()) {
            return response()->json([
                'status_code' => 400,
                'errors'      => true,
                'message'     => 'Empty Data'
            ], 400);
        }

        return response()->json([
            'data'       => $mappedData,
            'status_code' => 200,
            'errors'     => false,
            'message'    => 'Success',
            'pagination' => $paginationMeta
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_user'     => 'required|integer',
                'desc'   => 'required|string',
                'dp'   => 'required|numeric|min:0',
                'file'  => 'required|file|mimes:pdf|max:10240',
            ]);

            DB::beginTransaction();

            $fileName = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('storage/uploads/po');

                // Pastikan folder tujuan ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Pindahkan file langsung ke public/storage
                $file->move($destinationPath, $fileName);
            }

            // Generate kode_po
            $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $kode_po = 'PO' . $request->id_user . $randomDigits;

            $po = Po::create([
                'kode_po'     => $kode_po,
                'id_user'      => $request->id_user,
                'desc'       => $request->desc,
                'dp'       => $request->dp,
                'file'  => $fileName,
            ]);

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message'     => 'Purchase Order added successfully!',
                'data'        => $po
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

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $decryptedId = Crypt::decryptString($request->id_po);
            $po = Po::with(['user'])->findOrFail($decryptedId);

            // Get the sequence number
            $urutan = Po::where('id_user', $po->id_user)
                ->where('created_at', '<=', $po->created_at)
                ->orderBy('created_at', 'asc')
                ->pluck('id')
                ->search($po->id) + 1;

            // Ambil semua order yang terkait user & po
            $orders = Order::with(['orderTracking'])->where('id_user', $po->id_user)
                ->where('id_po', $po->id)
                ->get();

            $totalTrackingSteps = $orders->count() * 10; // total maksimal step dari semua order
            $completedSteps = 0;

            // Hitung semua step yang berstatus "complete"
            foreach ($orders as $order) {
                $completedSteps += $order->orderTracking
                    ->where('status', 'completed') // Ganti ini sesuai kolom status-mu
                    ->count();
            }

            $percentage = $totalTrackingSteps > 0
                ? ($completedSteps / $totalTrackingSteps) * 100
                : 0;

            $percentage = fmod($percentage, 1) == 0
                ? (int) $percentage // Kalau bulat, jadikan integer
                : round($percentage, 1); // Kalau ada koma, bulatkan 1 angka di belakang koma

            return response()->json([
                'status_code' => 200,
                'errors'     => false,
                'message'    => 'Success',
                'data'       => [
                    'id'         => $po->id,
                    'kode_po'    => $po->kode_po,
                    'id_user'    => $po->user->id,
                    'buyer_name' => $po->user->name,
                    'desc'       => $po->desc,
                    'dp'         => $po->dp,
                    'file'       => $po->file,
                    'percentage' => $percentage,
                    'status'     => OrderStatus::from($po->status)->label(),
                    'urutan'     => $po->user->name . ' #' . $urutan,
                ]
            ], 200);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'status_code' => 400,
                'errors'     => true,
                'message'    => 'Invalid encryption string'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'errors'     => true,
                'message'    => 'Something went wrong!',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($id);

            $request->validate([
                'status' => ['required', 'in:NC,PC']
            ]);

            $po->status = OrderStatus::from($request->status);
            $po->save();

            // Update all orders under this PO
            Order::where('id_po', $po->id)->update([
                'status' => OrderStatus::from($request->status)
            ]);

            DB::commit();
            return response()->json([
                'status_code' => 200,
                'errors'     => false,
                'message'    => 'Status updated successfully',
                'data'        => [
                    'id'     => $po->id,
                    'status' => $po->status->label(),
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status_code' => 500,
                'errors'     => true,
                'message'    => 'Something went wrong!',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
