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

        Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => json_encode($imagePaths),
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
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
        // Retrieve the product by ID
        $product = Product::findOrFail($id);

        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update product details (excluding images)
        $product->update([
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
        ]);

        // Handle image deletions
        $deletedImages = $request->input('deleted_images', []);
        if ($deletedImages) {
            // Get existing images (if any)
            $productImages = json_decode($product->image, true) ?? [];

            foreach ($deletedImages as $deletedImage) {
                if (($key = array_search($deletedImage, $productImages)) !== false) {
                    // Delete image from storage
                    if (Storage::exists('public/' . $deletedImage)) {
                        Storage::delete('public/' . $deletedImage);
                    }

                    // Remove image from the array
                    unset($productImages[$key]);
                }
            }

            // Reassign the updated images to the product
            $product->image = !empty($productImages) ? json_encode(array_values($productImages)) : null;
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $image) {
                // Store each new image and add it to the array
                $path = $image->store('product', 'public');
                $newImages[] = $path;
            }

            // Get current images (if any) and merge with new ones
            $productImages = json_decode($product->image, true) ?? [];
            $product->image = json_encode(array_merge($productImages, $newImages));
        }

        // Save the updated product
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
