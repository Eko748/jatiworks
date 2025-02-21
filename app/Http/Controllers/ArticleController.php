<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title['Article'];
    }

    public function index()
    {
        $title = $this->title['0'];

        return view('admin.article.index', compact('title'));
    }

    public function getdataarticle(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = Article::all()->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->whereRaw("LOWER(title) LIKE ?", ["%$searchTerm%"]);
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
                'id'     => $item->id,
                'file_name'  => $item->file_name,
                'title'  => $item->title,
                'desc'  => $item->desc,
                'status'  => $item->status,
                'startDate'  => $item->startDate,
                'endDate'  => $item->endDate,
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
                'startDate'  => 'required|date',
                'endDate'    => 'required|date|after_or_equal:startDate',
            ]);

            DB::beginTransaction();

            $fileName = null;

            if ($request->hasFile('article')) {
                foreach ($request->file('article') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('uploads/article', $fileName, 'public');
                }
            }

            $now = now();

            if ($request->startDate <= $now && $now <= $request->endDate) {
                $status = 'Yes';
            } else {
                $status = 'No';
            }

            $article = Article::create([
                'item_name'  => $request->item_name,
                'file_name'  => $fileName,
                'desc'       => $request->desc,
                'status'     => $status,
                'startDate'  => $request->startDate,
                'endDate'    => $request->endDate,
            ]);

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message'     => 'Article added successfully!',
                'data'        => $article
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
