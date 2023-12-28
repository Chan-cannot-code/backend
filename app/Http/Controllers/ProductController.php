<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'quantity' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required',
        ]);

        $user = $request->user();
        $quantity = $request->input('quantity', 0);

        // Initialize $filename with a default value
        $filename = null;

        $validatedData = [
            'quantity' => $quantity,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
            'school_id_id' => $user->id,
            'school_id' => $user->school_id,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalExtension = $file->getClientOriginalExtension();
            $filename = time() . rand() . '.' . $originalExtension;
            $file->storeAs('public/images', $filename);
        }

        // Update the $validatedData array only if $filename is defined
        if ($filename !== null) {
            $validatedData['image'] = $filename;
        }

        $product = $user->products()->create($validatedData);

        return response()->json(['data' => $product, 'message' => 'Product created successfully'], 201);
    }



    public function displayAllItems()
    {
        // Fetch all products from the 'products' table
        $products = Products::all();

        // Loop through each product and append the image URL
        foreach ($products as $product) {
            $product->image_url = asset("storage/images/{$product->image}");
        }

        // Return the products with appended image URLs
        return response()->json($products);
    }

}
