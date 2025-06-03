<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * Inject the ProductRepository dependency.
     *
     * @param ProductRepository $repository
     */
    public function __construct(
        public readonly ProductRepository $repository
    ) {
        //
    }

    /**
     * Display a paginated list of products, with optional filters from request.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $products = $this->repository->all($request);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created product in the database.
     *
     * @param ProductRequest $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        // Merge validated request data with additional fields
        $data = array_merge(
            $request->validated(),
            [
                'slug'         => Str::slug($request->name),
                'published_at' => now(),
            ]
        );

        $product = $this->repository->create($data);

        return new ProductResource($product);
    }

    /**
     * Display a single product.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified product in the database.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(ProductRequest $request, Product $product)
    {
        // Merge validated request data with slug and published_at
        $data = array_merge(
            $request->validated(),
            [
                'slug'         => Str::slug($request->name),
                'published_at' => now(),
            ]
        );

        $updatedProduct = $this->repository->update($data, $product);

        return new ProductResource($updatedProduct);
    }

    /**
     * Delete the specified product from the database.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $this->repository->delete($product);

        return response()->json(null, 204);
    }

    /**
     * Get basic statistics about products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        $stats = $this->repository->stats();

        return response()->json($stats);
    }
}