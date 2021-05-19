<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class GeneralController extends Controller
{
    public function bid(Item $item)
    {
        $item->photos;
        $item->category;
        $item->bids;

        return Inertia::render('App/Bid/item.vue', [
            '_item' => $item
        ]);
    }
}
