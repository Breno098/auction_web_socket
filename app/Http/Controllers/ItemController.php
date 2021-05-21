<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

use App\Models\Item;
use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['photos', 'category', 'bids'])
                    ->where('status', 'open')
                    ->orderBy('created_at')
                    ->get();

        return Inertia::render('App/Item', [
            'items' => $items
        ]);
    }

    public function create()
    {
        return Inertia::render('App/Item/create', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $item = Item::create($request->all());

        collect($request->photos)->each(function($photo) use ($item){
            $name_photo = Carbon::now()->format('YmdHis') . $photo['photo']->getClientOriginalName();

            if(!$photo['photo']->storeAs('/items', $name_photo)){
                return dd([ 'error' => "Erro ao fazer o upload da foto" ]);
            }

            $item->photos()->create([
                'name' => $name_photo,
                'image_path' => '/storage/items/' . $name_photo,
                'description' => $photo['description']
            ]);
        });

        return Redirect::route('item.index');
    }

    public function edit(Item $item)
    {
        $item->photos;

        return Inertia::render('App/Item/create', [
            'item' => $item,
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->all());

        return Redirect::route('item.index');
    }

    public function updateWithImage(Request $request, Item $item)
    {
        $item->update($request->all());

        collect($request->photos)->each(function($photo) use ($item){

            if(isset($photo['photo'])){
                $name_photo = Carbon::now()->format('YmdHis') . $photo['photo']->getClientOriginalName();

                if(!$photo['photo']->storeAs('/items', $name_photo)){
                    return dd([ 'error' => "Erro ao fazer o upload da foto" ]);
                }

                $item->photos()->create([
                    'name' => $name_photo,
                    'image_path' => '/storage/items/' . $name_photo,
                    'description' => $photo['description']
                ]);
            }

        });

        return Redirect::route('item.index');
    }

    public function destroy(Item $item)
    {
        try {
            $item->delete();
        } catch(\Exception $e){
            dd($e);
        }

        return Redirect::route('item.index');
    }
}
