<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where('name', 'like', "%$search%")
                ->orWhere('price', 'like', "%$search%");
        }

        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $products = $query->orderBy('id', 'desc')->paginate(5);

        return view('products.index', compact('products', 'user'));
    }


    public function show($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }
        $product = Product::findOrFail($id);

        return view('products.show', compact('product', 'user'));
    }


    public function edit($id)
    {

        $categories = Category::all();
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product', 'user', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Get the old images
        $oldImages = json_decode($product->image, true) ?? [];

        // Handle image deletion
        $deletedImages = $request->input('deleted_images');
        if ($deletedImages) {
            $deletedImages = explode(',', $deletedImages);
            foreach ($deletedImages as $deletedImage) {
                if (in_array($deletedImage, $oldImages)) {
                    // Remove image from the disk
                    Storage::delete('public/' . $deletedImage);
                    // Remove image from the database
                    $oldImages = array_filter($oldImages, fn($img) => $img !== $deletedImage);
                }
            }
        }

        // Handle new images upload
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newImages[] = $image->store('product_images', 'public');
            }
        }

        // Combine old images (excluding deleted ones) and new images
        $updatedImages = array_merge($oldImages, $newImages);

        // Update the product in the database
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => json_encode($updatedImages),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    public function create()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }
        $categories = Category::all();

        return view('products.create', compact('user', 'categories'));
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);


        $imagePaths = [];


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('product', 'public');
            }
        }


        $product = Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => json_encode($imagePaths),
        ]);


        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'product' => $product,
            ]);
        }


        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'User deleted successfully');
    }

}
