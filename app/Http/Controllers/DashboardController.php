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
        $items = Item::where('status', 'open')->orderBy('created_at')->get();

        foreach ($items as $item) {
            $item->photos;
            $item->category;
            $item->bids;
        }

        return Inertia::render('App/Dashboard', [
            '_items' => $items,
            '_categories' => Category::orderby('name')->get()
        ]);
    }

    public function bid(Int $id)
    {
        return Inertia::render('App/Bid/item.vue');
    }
}
