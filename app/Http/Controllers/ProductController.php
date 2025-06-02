<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{

    public const PAGINATE = 12;

    /**
     * Display a paginated listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        $products = $query
            ->filter($request->only([
                'name',
                'is_active',
                'min_price',
                'max_price',
                'min_stock',
                'max_stock',
            ]))
            ->latest()
            ->paginate(self::PAGINATE);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created product.
     */
    public function store(ProductRequest $request)
    {
        return new ProductResource(Product::create(array_merge(
            $request->validated(),
            ['slug' => Str::slug($request->name), 'published_at' => now()]
        )));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified product.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update(array_merge(
            $request->validated(),
            [
                'slug' => \Illuminate\Support\Str::slug($request->name),
                'published_at' => now(),
            ]
        ));

        return new ProductResource($product);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
    
    /**
     * Get statistics for products.
     */
    public function stats()
    {
        $stats = [
            'total_products'        => Product::count(),
            'active_products'       => Product::where('is_active', true)->count(),
            'inactive_products'     => Product::where('is_active', false)->count(),
            'average_price'         => Product::avg('price'),
        ];

        return response()->json($stats);
    }

}
