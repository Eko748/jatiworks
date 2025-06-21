<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\CustomDesign;
use App\Models\DesignTracking;
use App\Models\TrackingStepDesign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\File;

class CustomDesignController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'Custom Design',
        ];
    }

    private function baseQuery()
    {
        return CustomDesign::select([
            'id',
            'code_design',
            'item_name',
            'price',
            'status',
            'desc',
            'id_user'
        ])->with([
            'user:id,name,email',
            'user.profile:id,id_user,address,phone',
            'file' => function ($query) {
                $query->select(['id', 'id_custom', 'file_name']);
            }
        ]);
    }

    public function index()
    {
        $title = $this->title[0];
        $user = User::where('id_role', 2)->get();

        $status = array_combine(
            array_map(fn($status) => $status->value, OrderStatus::cases()),
            array_map(fn($status) => $status->label(), OrderStatus::cases())
        );

        return view('admin.custom.index', compact('title', 'status', 'user'));
    }

    public function detail()
    {
        $title = $this->title[0];

        return view('admin.custom.detail', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'id_user' => 'required|integer|exists:users,id',
                'item_name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'desc' => 'required|string',
                'file.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
            ]);

            $customDesign = CustomDesign::create([
                'id_user' => $request->id_user,
                'item_name' => $request->item_name,
                'price' => $request->price,
                'desc' => $request->desc
            ]);

            // Generate code_design
            $design_id = $customDesign->id;
            $id_user_str = (string) $request->id_user;
            $total_length = strlen($id_user_str);
            $random_length = max(0, 6 - $total_length);
            $random_number = str_pad(mt_rand(0, pow(10, $random_length) - 1), $random_length, '0', STR_PAD_LEFT);
            $code_design = $id_user_str . $design_id . $random_number;
            $customDesign->update(['code_design' => $code_design]);

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();

                    $file->storeAs('public/uploads/custom', $filename);

                    File::create([
                        'id_custom' => $customDesign->id,
                        'file_name' => $filename
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message' => 'Custom design successfully created!',
                'data' => $customDesign->load('file')
            ], 201);
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

    public function getDetailDataDesign(Request $request)
    {
        try {
            $decryptedId = Crypt::decryptString($request->encrypt);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 400,
                'message' => 'Invalid ID',
                'error'   => true
            ], 400);
        }

        $data = $this->baseQuery()
            ->with([
                'designTracking' => function ($query) {
                    $query->select([
                        'id',
                        'id_custom_design',
                        'id_tracking_step_design',
                        'status',
                        'notes',
                        'file_name',
                        'completed_at'
                    ])->with([
                        'trackingStepDesign:id,step_name'
                    ]);
                }
            ])
            ->findOrFail($decryptedId);

        $formattedData = [
            'id'          => Crypt::encryptString($data->id),
            'code_design' => $data->code_design,
            'item_name'   => $data->item_name,
            'price'       => $data->price,
            'status'      => method_exists($data->status, 'label') ? $data->status->label() : $data->status,
            'desc'        => $data->desc,
            'buyer'       => [
                'name'    => optional($data->user)->name,
                'email'   => optional($data->user)->email,
                'phone'   => optional($data->user->profile)->phone,
                'address' => optional($data->user->profile)->address,
            ],
            'file' => optional($data->file)->map(function ($file) {
                return ['file_name' => $file->file_name];
            })->toArray(),
            'tracking' => $data->designTracking->map(function ($tracking) {
                $fileNames = json_decode($tracking->file_name, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($fileNames)) {
                    $fileNames = $fileNames;
                } elseif (!empty($tracking->file_name)) {
                    $fileNames = $tracking->file_name;
                } else {
                    $fileNames = null;
                }

                return [
                    'id'                      => $tracking->id,
                    'id_custom_design'        => $tracking->id_custom_design,
                    'id_tracking_step_design' => $tracking->id_tracking_step_design,
                    'status'                  => $tracking->status,
                    'notes'                   => $tracking->notes,
                    'file_name'               => $fileNames,
                    'completed_at'            => $tracking->completed_at,
                    'step_name'               => $tracking->trackingStepDesign->step_name ?? null
                ];
            })
        ];

        return response()->json([
            'status'  => 200,
            'data'    => $formattedData,
            'message' => 'Successfully',
            'error'   => false
        ], 200);
    }

    public function getdatadesign(Request $request)
    {
        try {
            $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
            $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

            $query = $this->baseQuery()->orderBy('id', $meta['orderBy']);

            if (!empty($request['search'])) {
                $searchTerm = trim(strtolower($request['search']));
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw("LOWER(item_name) LIKE ?", ["%$searchTerm%"])
                        ->orWhereRaw("LOWER(code_design) LIKE ?", ["%$searchTerm%"]);
                });
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

            $data = $query->paginate($meta['limit']);

            $formattedData = $data->map(function ($item) {
                return [
                    'id'          => Crypt::encryptString($item->id),
                    'code_design' => $item->code_design,
                    'item_name'   => $item->item_name,
                    'price'       => $item->price,
                    'status'      => method_exists($item->status, 'label') ? $item->status->label() : $item->status,
                    'desc'        => $item->desc,
                    'buyer_name'  => optional($item->user)->name,
                    'file'        => $item->file->map(function ($file) {
                        return [
                            'id' => $file->id,
                            'file_name' => $file->file_name
                        ];
                    })->toArray()
                ];
            });

            if ($formattedData->isEmpty()) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'No data found',
                    'error'   => true
                ], 400);
            }

            $paginationMeta = [
                'total'        => $data->total(),
                'per_page'     => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages'  => $data->lastPage()
            ];

            return response()->json([
                'status'     => 200,
                'data'       => $formattedData,
                'pagination' => $paginationMeta,
                'message'    => 'Successfully',
                'error'      => false
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
                'error'   => true
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        // Validate request data first
        $validator = validator($request->all(), [
            'encrypt' => 'required|string',
            'status' => ['required', 'string', 'in:WP,NC,PC']
        ], [
            'encrypt.required' => 'ID is required',
            'status.required' => 'Status is required',
            'status.in' => 'Invalid status value'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
                'error' => true
            ], 422);
        }

        try {
            $decryptedId = Crypt::decryptString($request->encrypt);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid encrypted ID',
                'error' => true
            ], 400);
        }

        DB::beginTransaction();

        // Find the custom design
        $custom = CustomDesign::findOrFail($decryptedId);
        $oldStatus = $custom->status;

        // Update the status
        $custom->status = OrderStatus::from($request->status);
        $custom->save();

        // Create order tracking records when status changes from WP to NC or PC
        if (
            $oldStatus === OrderStatus::WaitingForPayment &&
            in_array($custom->status, [OrderStatus::NotCompleted, OrderStatus::PaymentCompleted])
        ) {

            $trackingSteps = TrackingStepDesign::orderBy('id')->get();

            foreach ($trackingSteps as $step) {
                DesignTracking::create([
                    'id_custom_design' => $custom->id,
                    'id_tracking_step_design' => $step->id,
                    'status' => $step->id === 1 ? 'in_progress' : 'pending',
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated successfully!',
            'error' => false,
            'data' => [
                'id' => Crypt::encryptString($custom->id),
                'status' => $custom->status->label()
            ]
        ], 200);
    }

    public function updateTrackingStep(Request $request)
    {
        $validator = validator($request->all(), [
            'encrypt' => 'required|string',
            'id_tracking_step_design' => 'required', // Remove string validation since it can be numeric
            'status' => 'nullable|in:pending,in_progress,completed',
            'notes' => 'nullable|string',
            'file.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
                'error' => true
            ], 422);
        }

        try {
            $decryptedCustomDesignId = Crypt::decryptString($request->encrypt);
            // Handle both encrypted and non-encrypted tracking step ID
            $decryptedTrackingStepId = is_numeric($request->id_tracking_step_design)
                ? $request->id_tracking_step_design
                : Crypt::decryptString($request->id_tracking_step_design);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid encrypted ID',
                'error' => true
            ], 400);
        }

        // Check if tracking step exists
        $designTracking = DesignTracking::where('id_custom_design', $decryptedCustomDesignId)
            ->where('id_tracking_step_design', $decryptedTrackingStepId)
            ->first();

        if (!$designTracking) {
            return response()->json([
                'status' => 404,
                'message' => 'Tracking step design not found',
                'error' => true
            ], 404);
        }

        // Use previous status if no new status provided
        $status = $request->status ?? $designTracking->status;

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

        $designTracking->update($data);

        // If current step is completed, update next step to in_progress
        if ($status === 'completed') {
            $currentStep = TrackingStepDesign::find($decryptedTrackingStepId);
            $nextStep = TrackingStepDesign::where('step_order', '>', $currentStep->step_order)
                ->orderBy('step_order')
                ->first();

            if ($nextStep) {
                DesignTracking::where('id_custom_design', $decryptedCustomDesignId)
                    ->where('id_tracking_step_design', $nextStep->id)
                    ->update(['status' => 'in_progress']);
            }
        }

        // Format response data with encrypted IDs
        $responseData = [
            'id' => Crypt::encryptString($designTracking->id),
            'id_custom_design' => $request->encrypt,
            'id_tracking_step_design' => $request->id_tracking_step_design,
            'status' => $designTracking->status,
            'notes' => $designTracking->notes,
            'file_name' => $designTracking->file_name,
            'completed_at' => $designTracking->completed_at
        ];

        return response()->json([
            'status' => 200,
            'message' => 'Tracking step updated successfully!',
            'error' => false,
            'data' => $responseData
        ], 200);
    }
}
