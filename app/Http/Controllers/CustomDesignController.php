<?php

namespace App\Http\Controllers;

use App\Models\CustomDesign;
use App\Models\DesignTracking;
use App\Models\TrackingStepDesign;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function index()
    {
        $title = $this->title[0];
        $user = User::where('id_role', 2)->get();
        $customDesigns = CustomDesign::with(['file', 'user'])->orderBy('id', 'desc')->get();

        $designTrackings = DesignTracking::with(['trackingStepdesign'])
            ->whereIn('id_custom_design', $customDesigns->pluck('id'))
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('id_custom_design');

        return view('admin.custom.index', compact('title', 'user', 'customDesigns', 'designTrackings'));
    }

    public function getdatadesign(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = CustomDesign::with(['file', 'user'])
            ->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->whereRaw("LOWER(item_name) LIKE ?", ["%$searchTerm%"]);
            $query->orwhereRaw("LOWER(code_design) LIKE ?", ["%$searchTerm%"]);
        }

        $data = $query->paginate($meta['limit']);

        $paginationMeta = [
            'total'        => $data->total(),
            'per_page'     => $data->perPage(),
            'current_page' => $data->currentPage(),
            'total_pages'  => $data->lastPage()
        ];

        if ($data->isEmpty()) {
            return response()->json([
                'status_code' => 400,
                'errors' => true,
                'message' => 'Data Not Found'
            ], 400);
        }

        $mappedData = collect($data->items())->map(function ($item) {
            return [
                'buyer_name'    => $item->user->name ?? null,
                'id'            => $item->id,
                'code_design'   => $item->code_design,
                'price'         => $item->price,
                'desc'          => $item->desc,
                'item_name'     => $item->item_name,
                'status'        => $item->status->label(),
                'file'          => $item->file->map(function ($file) {
                    return [
                        'id'        => $file->id,
                        'file_name' => $file->file_name,
                    ];
                })
            ];
        });

        return response()->json([
            'data'       => $mappedData,
            'status_code' => 200,
            'errors'     => false,
            'message'    => 'Success',
            'pagination' => $paginationMeta
        ], 200);
    }

    public function detail($id)
    {
        $title = $this->title[0];
        $customDesign = CustomDesign::with(['file', 'user'])
            ->findOrFail($id);

        $designTracking = DesignTracking::with(['trackingStepdesign'])
            ->where('id_custom_design', $id)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.custom.detail', compact('title', 'customDesign', 'designTracking'));
    }
}
