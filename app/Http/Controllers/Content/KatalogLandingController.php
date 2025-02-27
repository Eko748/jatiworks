<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class KatalogLandingController extends Controller
{
    private array $menu = [];
    private array $title = [];

    public function __construct()
    {
        $this->menu;
        $this->title = [
            'Data Catalogue - Jatiworks',
        ];
    }
    public function index()
    {
        $title = $this->title[0];
        $category = Category::all();

        return view('buyer.pages.katalog.index', compact('title', 'category'));
    }
}
