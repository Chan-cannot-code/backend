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

        // Extract quantity from the request or set a default value
        $quantity = $request->input('quantity', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Get the original file extension
            $originalExtension = $file->getClientOriginalExtension();

            // Generate a unique filename with the correct extension
            $filename = time() . rand() . '.' . $originalExtension;

            // Log the original and generated file names
            \Log::info("Original Filename: {$file->getClientOriginalName()}, Generated Filename: $filename");

            // Save the image file with the correct extension
            $file->storeAs('public/images', $filename);

            // Add the image file name and quantity to the validated data
            $validatedData = [
                'image' => $filename,
                'quantity' => $quantity,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'category' => $request->input('category'),
                'school_id_id' => $user->id,
                'school_id' => $user->school_id,
            ];
        }

        // Create the product using the validated data
        $product = $user->products()->create($validatedData);

        // Return the product details with a success message
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
