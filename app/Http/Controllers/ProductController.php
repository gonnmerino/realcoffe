<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::where('is_published', true)->paginate(5);

    return view('products.index', compact('products'));
  }

  public function create()
  {
    return view('products.create', ['categories' => Category::all()]);
  }

  public function edit($id)
  {
    $product = Product::with('image')->findOrFail($id);
    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
  }

  public function update(Request $request, $id)
  {
    $product = Product::findOrFail($id);

    $validated = $request->validate([
      'name' => 'required|string|max:100',
      'description' => 'required|string|max:255',
      'price' => 'required|numeric|max:999999999999.99',
      'stock' => 'required|integer',
      'is_featured' => 'nullable|boolean',
      'image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
      'category_id' => 'required|exists:categories,id',
    ], [
      'price.max' => 'Excediste el precio maximo'
    ]);

    DB::transaction(function () use ($request, $validated, $product) {

      $product->update([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'stock' => $validated['stock'],
        'is_featured' => $request->has('is_featured'),
        'category_id' => $validated['category_id'],
      ]);

      if ($request->hasFile('image') && $request->file('image')->isValid()) {
        if ($product->image) {
          Storage::disk('public')->delete($product->image->path);
          $product->image->delete();
        }
        $imagePath = $request->file('image')->store('products', 'public');
        Image::create([
          'path' => $imagePath,
          'alt' => $validated['name'] . ' - ' . $validated['description'],
          'product_id' => $product->id,
        ]);
      }
    });

    return redirect()->route('products.index')->with('success', 'Producto Actualizado!');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:100',
      'description' => 'required|string|max:255',
      'price' => 'required|numeric|max:999999999999.99',
      'stock' => 'required|integer',
      'is_featured' => 'nullable|boolean',
      'category_id' => 'required|exists:categories,id',

      //image
      'image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
    ]);
    $is_featured = $request->has('is_featured');
    if(!$is_featured) {
      $validated['is_featured'] = false;
    }

    DB::transaction(function () use ($request, $validated) {
      $product = Product::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'stock' => $validated['stock'],
        'is_featured' => $validated['is_featured'],
        'category_id' => $validated['category_id'],
      ]);
      if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $imagePath = $request->file('image')->store('products', 'public');

        $image = Image::create([
          'path' => $imagePath,
          'alt' => $validated['name'] . ' - ' . $validated['description'],
          'product_id' => $product->id,
        ]);
      }
    });

    return redirect()->route('products.index')->with('success', 'Product created!');
  }


}
