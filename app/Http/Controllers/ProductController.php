<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {

//        dd($request->all());
        $product = new Product();
        $product->title = $request->input('title');
        $product->description = $request->input('description');

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->storeAs('public/images', $imageName);

                $imagePaths[] = $imageName;
            }

            $product->images = json_encode($imagePaths);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public
    function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(Product $product)
    {
        return view('products.update', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductsRequest $request, Product $product)
    {
        $product->title = $request->input('title');
        $product->description = $request->input('description');

        $newImagePaths = [];

        if ($request->hasFile('images')) {
            if ($product->images) {
                foreach (json_decode($product->images, true) as $existingImage) {
                    \Storage::delete('public/images/' . $existingImage);
                }
            }

            // Handle the new images
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->storeAs('public/images', $imageName);

                $newImagePaths[] = $imageName;
            }

            $product->images = json_encode($newImagePaths);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(Product $product)
    {
        if ($product->images) {
            foreach (json_decode($product->images, true) as $existingImage) {
                \Storage::delete('public/images/' . $existingImage);
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
