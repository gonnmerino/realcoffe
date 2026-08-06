<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
  public function index() {
    $categories = Category::paginate(8);
    return view('categories.index', compact('categories'));
  }

  public function create() {
    return view('categories.create');
  }

  public function edit($id) {
    $category = Category::findOrFail($id);
    return view('categories.edit', compact('category'));
  }

  public function update($id, Request $request) {
    $category = Category::findOrFail($id);
    $validated  = $request->validate([
      'name' => 'required|unique:categories|string|max:255',
    ]);

    DB::transaction(function() use($validated, $category) {
      $category->update($validated);
      $category->save();
    });
      return redirect()->route('categories.index')->with('success', 'Categoria actualizada correctamente');
  }

  public function store(Request $request) {
    $validated = $request->validate([
      'name' => 'required|string|max:100',
      'description' => 'required|string|max:255',
    ]);
    DB::transaction(function () use ($validated) {
      Category::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
      ]);
    });

    return redirect()
      ->route('categories.index')->with('success', 'Categoria creada correctamente');
  }
}
