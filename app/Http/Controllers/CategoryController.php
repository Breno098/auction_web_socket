<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('App/Category', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('App/Category/create');
    }

    public function store(Request $request)
    {
        Category::create($request->all());

        return Redirect::route('category.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('App/Category/create', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        return Redirect::route('category.index');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch(\Exception $e){
            dd($e);
        }

        return Redirect::route('category.index');
    }
}
