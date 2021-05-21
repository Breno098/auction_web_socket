<?php

namespace App\Http\Controllers;

use App\Events\ItemOpen;
use App\Events\ItemServer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class GeneralController extends Controller
{
    public function bid(Item $item)
    {
        return Inertia::render('App/Bid/item.vue', [
            '_item' => $item->load(['bids.user', 'category', 'photos'])
        ]);
    }

    public function setBid(Item $item)
    {
        $atualBid= $item->bids()->orderBy('id', 'desc')->first();

        $item->bids()->create([
            'value' => isset($atualBid) ? $atualBid->value + $item->bid_minimum_value : $item->initial_value + $item->bid_minimum_value,
            'date' => now(),
            'user_id' => Auth::user()->id,
        ]);

        broadcast(new ItemServer($item));

        broadcast(new ItemOpen());

        return response()->json( Auth::user()->bids );
    }
}
