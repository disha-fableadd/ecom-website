<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(5);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Update product details
        $product->update($validatedData);
    
        // Handle image upload if exists
        if ($request->hasFile('image')) {
            // Store the new image
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }
    
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'User deleted successfully');
    }

}
