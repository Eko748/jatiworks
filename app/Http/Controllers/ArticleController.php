<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private array $title = ['' => 'Article'];

    public function __construct()
    {
        $this->title[''] = 'Article - Jatiworks';
    }

    public function index()
    {
        $title = $this->title[''];

        return view('admin.article.index', compact('title'));
    }


    public function getdataarticle(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = Article::query()->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->whereRaw("LOWER(title) LIKE ?", ["%$searchTerm%"]);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $query->whereBetween('id', [$start_date, $end_date]);
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
                'start_date'  => $item->start_date,
                'end_date'  => $item->end_date,
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
                'article'  => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'title'    => 'nullable|string|max:255',
                'desc'     => 'nullable|string|max:255',
                'status'   => 'nullable|string|max:255',
                'start_date'  => 'required|date',
                'end_date'    => 'required|date|after_or_equal:start_date',
            ]);

            DB::beginTransaction();

            $fileName = null;

            if ($request->hasFile('article')) {
                $file = $request->file('article');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads/article', $fileName, 'public');
            }

            $now = now();
            $status = ($request->start_date <= $now && $now <= $request->end_date) ? 'Yes' : 'No';

            $article = Article::create([
                'file_name'  => $fileName,
                'title'       => $request->title,
                'desc'       => $request->desc,
                'status'     => $status,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
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

    public function updateStatus(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);

            // Toggle status (Yes <-> No)
            $article->status = ($article->status === 'Yes') ? 'No' : 'Yes';
            $article->save();

            return response()->json([
                'status_code' => 200,
                'message'     => 'Status updated successfully!',
                'data'        => $article
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'errors'      => true,
                'message'     => 'Something went wrong!',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
