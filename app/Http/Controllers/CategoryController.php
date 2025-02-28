<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

final class CategoryController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'slug' => 'required',
            'status' => 'required|integer|between:0,1',
        ]);

        $catin = Category::create($validated);

        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return view('categories.index');
    }
}
