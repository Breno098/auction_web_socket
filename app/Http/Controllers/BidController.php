<?php

namespace App\Http\Controllers;

use App\Events\OpenStatusItems;
use App\Events\BidsToItem;
use App\Events\BidsToUser;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class BidController extends Controller
{
    public function setToUser(Item $item)
    {
        $item->load(['latestBid']);

        $final = $item->real_final_date->diffInMinutes(now(), false);
        if($final > -10 && $final < 0){
            $item->update([
                'real_final_date' => $item->real_final_date->addMinutes(10)
            ]);
        }

        $valuenextBid = isset($item->latestBid) ? $item->latestBid->value + $item->bid_minimum_value : $item->initial_value + $item->bid_minimum_value;

        $item->bids()->create([
            'value' => $valuenextBid,
            'date' => now(),
            'user_id' => Auth::user()->id,
        ]);

        $this->updateChannelsInformations($item);

        return response()->json([]);
    }

    private function updateChannelsInformations($item)
    {
        broadcast(new OpenStatusItems);

        broadcast(new BidsToItem($item));

        broadcast(new BidsToUser);
    }
}
