<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $items = Item::with(['photos', 'category', 'bids'])
                     ->withCount('bids')
                     ->where('status', 'open')
                     ->orderBy('created_at')
                     ->get();

        return Inertia::render('App/Dashboard', [
            '_items' => $items,
            '_categories' => Category::orderby('name')->get()
        ]);
    }
}
