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

        $data = [
            'data' => $data->items(),
            'meta' => $paginationMeta
        ];

        if (empty($data['data'])) {
            return response()->json([
                'status_code' => 400,
                'errors' => true,
                'message' => 'Tidak ada data'
            ], 400);
        }

        $mappedData = collect($data['data'])->map(function ($item) {
            return [
                'id'         => $item->id,
                'item_name'  => $item->item_name,
                'material'   => $item->material,
                'length'     => $item->length,
                'width'      => $item->width,
                'height'     => $item->height,
                'unit'       => $item->unit,
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

        return response()->json([
            'data'       => $mappedData,
            'status_code' => 200,
            'errors'     => true,
            'message'    => 'Success',
            'pagination' => $data['meta']
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
                'unit'       => 'string',
                'category'   => 'required|array',
                'category.*' => 'string', // Bisa id kategori atau kategori baru dalam teks
                'file'       => 'nullable|array',
                'file.*'     => 'file|mimes:jpg,jpeg,png|max:2048'
            ]);

            DB::beginTransaction();

            // Buat katalog baru
            $katalog = Katalog::create([
                'item_name' => $request->item_name,
                'material'  => $request->material,
                'length'    => $request->length,
                'width'     => $request->width,
                'height'    => $request->height,
                'desc'      => $request->desc,
                'unit'      => $request->unit,
            ]);

            $categoryIds = [];

            foreach ($request->category as $cat) {
                if (is_numeric($cat)) {
                    $categoryIds[] = $cat; // Jika sudah ada, langsung gunakan ID-nya
                } else {
                    $category = Category::where('name_category', $cat)->first();

                    if (!$category) {
                        $category = Category::create(['name_category' => $cat]);
                    }

                    $categoryIds[] = $category->id;
                }
            }

            // Hubungkan kategori dengan katalog
            $katalog->category()->sync($categoryIds);

            // Simpan file jika ada
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
                'message'     => 'Catalog added successfully!',
                'data'        => $katalog->load('category', 'file')
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
}
