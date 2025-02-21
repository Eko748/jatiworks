<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
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
        $category = Category::all();

        return view('admin.katalog.index', compact('title', 'category'));
    }

    public function getdatakatalog(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = Katalog::with(['category', 'file'])
            ->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->whereRaw("LOWER(item_name) LIKE ?", ["%$searchTerm%"]);
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
                'item_name'  => $item->item_name,
                'material'   => $item->material,
                'length'     => $item->length,
                'width'      => $item->width,
                'height'     => $item->height,
                'desc'       => $item->desc,
                'category' => $item->category->map(function ($category) {
                    return [
                        'id_category' => $category->id,
                        'name_category' => $category->name_category,
                    ];
                }),
                'file' => $item->file->map(function ($file) {
                    return [
                        'id'        => $file->id,
                        'file_name' => $file->file_name,
                    ];
                })
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

    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_name'  => 'required|string|max:255',
                'material'   => 'nullable|string|max:255',
                'length'     => 'nullable|numeric',
                'width'      => 'nullable|numeric',
                'height'     => 'nullable|numeric',
                'desc'       => 'nullable|string',
                'category' => 'required|array',
                'category.*' => 'exists:category,id',
                'file'      => 'nullable|array',
                'file.*'    => 'file|mimes:jpg,jpeg,png|max:2048'
            ]);

            DB::beginTransaction();

            $katalog = Katalog::create([
                'item_name' => $request->item_name,
                'material'  => $request->material,
                'length'    => $request->length,
                'width'     => $request->width,
                'height'    => $request->height,
                'desc'      => $request->desc,
            ]);

            $katalog->category()->sync($request->category);

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('uploads/katalog', $filename, 'public');

                    File::create([
                        'id_katalog' => $katalog->id,
                        'file_name'  => $filename
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message'     => 'Catalog added Successful !',
                'data'        => $katalog->load('category', 'file')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status_code' => 500,
                'errors'      => true,
                'message'     => 'Something Wrong !',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
