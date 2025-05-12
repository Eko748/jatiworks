<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;

class InformationController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'CMS - Information',
        ];
    }

    public function index()
    {
        $title = $this->title[0];

        $data = Information::first();

        return view('admin.cms.information.index', compact('title', 'data'));
    }

    public function getData()
    {
        try {
            $data = Information::first();

            if ($data) {
                return response()->json([
                    'data'       => $data,
                    'status_code' => 200,
                    'errors'     => false,
                    'message'    => 'Success',
                ], 200);
            } else {
                return response()->json([
                    'data'       => null,
                    'status_code' => 404,
                    'errors'     => true,
                    'message'    => 'Data not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'data'       => null,
                'status_code' => 500,
                'errors'     => true,
                'message'    => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
{
    $request->validate([
        'address'   => 'nullable|string|max:500',
        'email'     => 'nullable|email|max:255',
        'phone'     => 'nullable|string|max:50',
        'linkedin'  => 'nullable|url|max:255',
        'youtube'   => 'nullable|url|max:255',
        'instagram' => 'nullable|url|max:255',
        'facebook'  => 'nullable|url|max:255',
        'tiktok'    => 'nullable|url|max:255',
    ]);

    // Cek jika data sudah ada (id = 1), maka update
    $info = Information::first(); // Ambil data pertama kali yang ada, hanya boleh ada 1 data

    if ($info) {
        // Jika data ada, update dengan data baru
        $info->update($request->all());
        return response()->json([
            'status_code' => 200,
            'message'     => 'Information updated successfully!',
        ], 200);
    } else {
        // Jika data belum ada, buat data pertama
        Information::create($request->all());
        return response()->json([
            'status_code' => 201,
            'message'     => 'Information added successfully!',
        ], 201);
    }
}

}
