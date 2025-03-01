<?php

namespace App\Http\Controllers;

use App\Models\CustomDesign;
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
        $customDesigns = CustomDesign::with(['file'])->orderBy('id', 'desc')->get();

        return view('admin.custom.index', compact('title', 'user', 'customDesigns'));
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

        return response()->json([
            'status' => 200,
            'data' => $data->items(),
            'pagination' => $paginationMeta
        ]);
    }
}
