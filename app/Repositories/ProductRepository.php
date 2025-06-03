<?php

namespace App\Repositories;

use App\Models\Product;

/**
 * ProductRepository handles data logic specific to the Product model.
 */
final class ProductRepository extends Repository
{
    /**
     * Specify the associated model class.
     *
     * @return string
     */
    public function model(): string
    {
        return Product::class;
    }

    /**
     * Get product-related statistics such as totals and averages.
     *
     * @return array
     */
    public function stats(): array
    {
        return [
            'total_products'    => $this->model::count(),
            'active_products'   => $this->model::where('is_active', true)->count(),
            'inactive_products' => $this->model::where('is_active', false)->count(),
            'average_price'     => round((float) $this->model::avg('price'), 2),
        ];
    }
}
