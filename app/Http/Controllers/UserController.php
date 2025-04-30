<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'Data User - Jatiworks',
        ];
    }

    public function getdatauser(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->has('limit') && $request->limit <= 30 ? $request->limit : 30;

        $query = User::query();

        $query->with(['role'])->orderBy('id', $meta['orderBy']);

        if (!empty($request['search'])) {
            $searchTerm = trim(strtolower($request['search']));

            $query->where(function ($query) use ($searchTerm) {
                $query->orWhereRaw("LOWER(name) LIKE ?", ["%$searchTerm%"]);
                $query->orWhereRaw("LOWER(email) LIKE ?", ["%$searchTerm%"]);

            });
        }

        if ($request->has('status_login')) {
            $params = $request->input('status_login');

            $query->whereIn('status', $params);
        }

        if ($request->has('role')) {
            $params = $request->input('role');

            $query->whereIn('id_role', $params);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('last_login_at', [$startDate, $endDate]);
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
                'message' => 'No data'
            ], 400);
        }

        $mappedData = collect($data['data'])->map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item->name,
                'role_name' => $item['role']->role_name,
                'email' => $item->email,
                'status' => $item->status,
                'last_login_at' => $item->last_login_at,
            ];
        });

        return response()->json([
            'data' => $mappedData,
            'status_code' => 200,
            'errors' => true,
            'message' => 'Sukses',
            'pagination' => $data['meta']
        ], 200);
    }

    public function index()
    {
        $title = $this->title[0];

        return view('admin.user.index', compact('title'));
    }
}
