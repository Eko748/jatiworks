<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function indexHome()
    {
        $title = 'Home';
        return view('buyer.pages.home.index', compact('title'));
    }

    public function indexCatalogue()
    {
        $title = 'Catalogue';
        return view('buyer.pages.catalogue.index', compact('title'));
    }

    public function detailCatalogue()
    {
        $title = 'Catalogue';
        return view('buyer.pages.catalogue.detail', compact('title'));
    }

    public function indexCustomDesign()
    {
        $title = 'Custom Design';
        return view('buyer.pages.customdesign.index', compact('title'));
    }

    public function detailCustomDesign()
    {
        $title = 'Custom Design';
        return view('buyer.pages.customdesign.detail', compact('title'));
    }

    public function indexOrder()
    {
        $title = 'Order';
        return view('buyer.pages.order.index', compact('title'));
    }
}
