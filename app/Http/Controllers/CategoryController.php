<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return Inertia::render('Category/Index',[
            'categories' => $categories
        ]);
    }
    public function create()
    {

        return Inertia::render('Category/Create');
    }
    public function store(Request $request)
    {

        $data = $request->validate([
          'name' => ['required', 'max:255'],
        ]);

        Category::create($data);
        return to_route('category.index');
    }
    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        $data = $request->validate([
          'name' => ['required', 'max:255'],
        ]);

        $category->update($data);
        return to_route('category.index');
    }
    public function delete()
    {

        return to_route('category.index');
    }
}
