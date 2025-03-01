<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\CustomDesign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
            $decryptedId = Crypt::decryptString($request->decode);
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
}
