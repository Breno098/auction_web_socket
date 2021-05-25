<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

use App\Models\Item;

class HomeController extends Controller
{
    public function index()
    {
        $items = Item::with(['photos', 'category', 'bids'])
                     ->withCount('bids')
                     ->where('status', 'open')
                     ->orderBy('created_at')
                     ->take(8)
                     ->get();

        return Inertia::render('App/Home', [
            '_items' => $items,
            '_categories' => Category::orderby('name')->get()
        ]);
    }

    public function itemsByCategory(Category $category)
    {
        $items = Item::with(['photos', 'category', 'bids'])
            ->withCount('bids')
            ->where('status', 'open')
            ->where('category_id', $category->id)
            ->orderBy('created_at')
            ->get();

        return Inertia::render('App/Home', [
            '_items' => $items,
            '_categories' => Category::orderby('name')->get()
        ]);
    }
}
