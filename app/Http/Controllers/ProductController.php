<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'index' => ['permission:product-list|product-create|product-edit|product-delete'],
            'show' => ['permission:product-list|product-create|product-edit|product-delete'],
            'create' => ['permission:product-create'],
            'store' => ['permission:product-create'],
            'edit' => ['permission:product-edit'],
            'update' => ['permission:product-edit'],
            'destroy' => ['permission:product-delete'],
        ];
    }
    public function index()
    {
        $products = Product::latest()->paginate(50);
        return view('products.index', compact('products'));
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
    public function store(Request $request)
    {
        //
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
