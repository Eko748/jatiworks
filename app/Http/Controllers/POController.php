<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Po;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'PO',
        ];
    }

    public function index()
    {
        $title = $this->title[0];
        $user = User::where('id_role', 2)->get();

        return view('admin.po.index', compact('title', 'user'));
    }

    public  function getdatapo(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = Po::with(['user'])->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));
            $query->whereRaw("LOWER(kode_po) LIKE ?", ["%$searchTerm%"]);
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
                'kode_po'  => $item->kode_po,
                'id_user'  => $item->user->name,
                'file'  => $item->file,
                'desc'  => $item->desc,
                'dp'  => $item->dp,
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_user'     => 'required|integer',
                'desc'   => 'required|string',
                'dp'   => 'required|numeric|min:0',
                'file'  => 'required|file|mimes:pdf|max:10240',
            ]);

            DB::beginTransaction();

            $fileName = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('storage/uploads/po');

                // Pastikan folder tujuan ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Pindahkan file langsung ke public/storage
                $file->move($destinationPath, $fileName);
            }

            // Generate kode_po
            $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $kode_po = 'PO' . $request->id_user . $randomDigits;

            $po = Po::create([
                'kode_po'     => $kode_po,
                'id_user'      => $request->id_user,
                'desc'       => $request->desc,
                'dp'       => $request->dp,
                'file'  => $fileName,
            ]);

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message'     => 'Purchase Order added successfully!',
                'data'        => $po
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
