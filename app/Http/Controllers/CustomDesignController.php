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
            'file:id,file_name'
        ]);
    }

    public function index()
    {
        $title = $this->title[0];

        $status = array_combine(
            array_map(fn($status) => $status->value, OrderStatus::cases()),
            array_map(fn($status) => $status->label(), OrderStatus::cases())
        );

        return view('admin.custom.index', compact('title', 'status'));
    }

    public function detail()
    {
        $title = $this->title[0];

        return view('admin.custom.detail', compact('title'));
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
            'file' => optional($data->file)->pluck('file_name')->toArray(),
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
                $query->whereRaw("LOWER(item_name) LIKE ?", ["%$searchTerm%"])
                    ->orWhereRaw("LOWER(code_design) LIKE ?", ["%$searchTerm%"]);
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
                    'file'        => optional($item->file)->pluck('file_name')->toArray()
                ];
            });

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
                $file->storeAs('uploads/tracking', $filename, 'public');
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
