<?php

namespace App\Http\Controllers;

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
            '_item' => $item->load(['bids.user', 'category', 'photos', 'latestBid'])
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
