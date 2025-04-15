<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Katalog;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\TrackingStep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'Order',
        ];
    }
    public function index()
    {
        // test
        $title = $this->title[0];
        $user = User::where('id_role', 2)->get();
        $katalog = Katalog::all();

        return view('admin.order.index', compact('title', 'user', 'katalog'));
    }

    public function getdataorder(Request $request)
    {

        try {
            $decryptedId = Crypt::decryptString($request->id_po);
            $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
            $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

            $query = Order::with(['katalog', 'user'])->where('id_po', $decryptedId)->orderBy('id', $meta['orderBy']);

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
                    'message' => 'No data found'
                ], 400);
            }

            $mappedData = collect($data->items())->map(function ($item) {
                return [
                    'id' => $item->id,
                    'code_order' => $item->code_order,
                    'buyer_name' => $item->user->name ?? null,
                    'item_name' => $item->id_katalog === null ? $item->item_name : ($item->katalog->item_name ?? null),
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'status' => $item->status->label(),
                    'detail_url' => route('admin.po.order.detail', $item->id),
                    'file' => $item->id_katalog && $item->katalog
                        ? ($item->katalog->file->map(function ($file) {
                            return [
                                'id'        => $file->id,
                                'file_name' => 'storage/uploads/katalog/' . $file->file_name,
                            ];
                        })->toArray())
                        : ($item->file->map(function ($file) {
                            return [
                                'id'        => $file->id,
                                'file_name' => 'storage/uploads/order/' . $file->file_name,
                            ];
                        })->toArray())
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
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan
            return response()->json([
                'status_code' => 500,
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $decryptedId = Crypt::decryptString($request->id_po);
            $id_user = $request->id_user;
            DB::beginTransaction();

            if ($request->filled('id_katalog')) {
                $validatedData = $request->validate([
                    'id_katalog' => 'required|integer|exists:katalog,id',
                    'qty'       => 'required|integer|min:1',
                    'price'     => 'required|numeric|min:0'
                ]);

                $order = Order::create([
                    'id_po' => $decryptedId,
                    'id_user'   => $id_user,
                    'id_katalog' => $validatedData['id_katalog'],
                    'qty'       => $validatedData['qty'],
                    'price'     => $validatedData['price'],
                ]);

                // Generate code_order for katalog orders
                $order_id = $order->id;
                $id_user_str = (string) $validatedData['id_user'];
                $total_length = strlen($id_user_str);
                $random_length = max(0, 6 - $total_length);
                $random_number = str_pad(mt_rand(0, pow(10, $random_length) - 1), $random_length, '0', STR_PAD_LEFT);
                $code_order = $id_user_str . $order_id . $random_number;
                $order->update(['code_order' => $code_order]);
            } else {
                $request->validate([
                    'id_user'   => 'required|integer',
                    'item_name' => 'required|string|max:255',
                    'material'  => 'required|string|max:255',
                    'length'    => 'required|numeric',
                    'width'     => 'required|numeric',
                    'height'    => 'required|numeric',
                    'weight'    => 'required|string',
                    'desc'      => 'required|string',
                    'unit'      => 'required|string',
                    'qty'       => 'required|integer|min:1',
                    'price'     => 'required|numeric|min:0',
                    'file'      => 'required|array',
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

                $order_id = $order->id;
                $id_user_str = (string) $request->id_user;
                $total_length = strlen($id_user_str);

                $random_length = max(0, 6 - $total_length);
                $random_number = str_pad(mt_rand(0, pow(10, $random_length) - 1), $random_length, '0', STR_PAD_LEFT);

                $code_order = $id_user_str . $order_id . $random_number;
                $order->update(['code_order' => $code_order]);

                if ($request->hasFile('file')) {
                    foreach ($request->file('file') as $file) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $destinationPath = public_path('storage/uploads/order');

                        // Pastikan folder tujuan ada
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }

                        // Pindahkan file langsung ke public/storage
                        $file->move($destinationPath, $filename);

                        File::create([
                            'id_order' => $order->id,
                            'file_name' => $filename
                        ]);
                    }
                }
            }

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
            DB::beginTransaction();
            $order = Order::findOrFail($id);

            $request->validate([
                'status' => ['required', 'in:WP,NC,PC']
            ]);

            $oldStatus = $order->status;
            $order->status = OrderStatus::from($request->status);
            $order->save();

            // Create order tracking records when status changes from WP to NC or PC
            if ($oldStatus === OrderStatus::WaitingForPayment && in_array($order->status, [OrderStatus::NotCompleted, OrderStatus::PaymentCompleted])) {
                $trackingSteps = TrackingStep::orderBy('step_order')->get();

                foreach ($trackingSteps as $step) {
                    OrderTracking::create([
                        'id_order' => $order->id,
                        'id_tracking_step' => $step->id,
                        'status' => $step->id === 1 ? 'in_progress' : 'pending',
                    ]);
                }
            }

            DB::commit();
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

    public function updateTrackingStep(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Validate the request data with custom error messages
            $validator = validator($request->all(), [
                'id_tracking_step' => 'required|exists:tracking_step,id',
                'status' => 'nullable|in:pending,in_progress,completed',
                'notes' => 'nullable|string',
                'file.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048' // Allow multiple files
            ], [
                'id_tracking_step.required' => 'The tracking step ID is required.',
                'id_tracking_step.exists' => 'The selected tracking step does not exist.',
                'status.in' => 'The status must be one of: pending, in_progress, completed.',
                'file.*.mimes' => 'Each file must be a JPG, JPEG, or PNG.',
                'file.*.max' => 'Each file must not exceed 2MB.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 422,
                    'errors' => true,
                    'message' => 'Validation failed',
                    'error_detail' => $validator->errors()->first()
                ], 422);
            }

            // Ambil data tracking order
            $orderTracking = OrderTracking::where('id_order', $id)
                ->where('id_tracking_step', $request->id_tracking_step)
                ->firstOrFail();

            // Gunakan status sebelumnya jika tidak ada request status
            $status = $request->status ?? $orderTracking->status;

            $data = [
                'status' => $status,
                'notes' => $request->notes,
                'completed_at' => $status === 'completed' ? now() : null
            ];

            // Handle multiple file uploads
            if ($request->hasFile('file')) {
                $fileNames = [];
                foreach ($request->file('file') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('storage/uploads/tracking');

                    // Pastikan folder tujuan ada
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    // Pindahkan file langsung ke public/storage
                    $file->move($destinationPath, $filename);
                    $fileNames[] = $filename;
                }
                $data['file_name'] = json_encode($fileNames);
            }

            $orderTracking->update($data);

            // If current step is marked as completed, update the next step to in_progress
            if ($status === 'completed') {
                $currentStep = TrackingStep::find($request->id_tracking_step);
                $nextStep = TrackingStep::where('step_order', '>', $currentStep->step_order)
                    ->orderBy('step_order')
                    ->first();

                if ($nextStep) {
                    OrderTracking::where('id_order', $id)
                        ->where('id_tracking_step', $nextStep->id)
                        ->update(['status' => 'in_progress']);
                }
            }

            DB::commit();
            return response()->json([
                'status_code' => 200,
                'message' => 'Tracking step updated successfully!',
                'data' => $orderTracking
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status_code' => 500,
                'errors' => true,
                'message' => 'Something went wrong!',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function detail($id)
    {
        $order = Order::with([
            'orderTracking.trackingStep' => function ($query) {
                $query->orderBy('step_order', 'asc');
            },
            'katalog',
            'user',
            'file'
        ])->findOrFail($id);

        $orderDetails = [
            'material' => $order->id_katalog === null ? $order->material : ($order->katalog->material ?? null),
            'length' => $order->id_katalog === null ? $order->length : ($order->katalog->length ?? null),
            'width' => $order->id_katalog === null ? $order->width : ($order->katalog->width ?? null),
            'height' => $order->id_katalog === null ? $order->height : ($order->katalog->height ?? null),
            'weight' => $order->id_katalog === null ? $order->weight : ($order->katalog->weight ?? null),
            'unit' => $order->id_katalog === null ? $order->unit : ($order->katalog->unit ?? null),
            'desc' => $order->id_katalog === null ? $order->desc : ($order->katalog->desc ?? null)
        ];

        $title = $this->title[0];

        return view('admin.order.detail', compact('title', 'order', 'orderDetails'));
    }
}
