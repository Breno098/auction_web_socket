<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class InformationController extends Controller
{
    public function item(Item $item)
    {
        return Inertia::render('App/Information/item.vue', [
            '_item' => $item->load(['bids.user', 'category', 'photos', 'latestBid'])->loadCount('bids')
        ]);
    }

    public function items(Category $category = null)
    {
        $items = Item::with(['photos', 'category'])
            ->withCount('bids')
            ->where('status', 'open')
            ->orderBy('created_at');

        if(isset($category)){
            $items->where('category_id', $category->id);
        }

        return Inertia::render('App/Information/items.vue', [
            '_items' => $items->get(),
            '_categories' => Category::orderby('name')->get()
        ]);
    }

    public function bidsToUser()
    {
        $user = Auth::user();

        return Inertia::render('App/Information/bidsToUser.vue', [
            '_user' => $user->load('bids.item.photos')
        ]);
    }
}
