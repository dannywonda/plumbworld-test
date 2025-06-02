<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'id',
        'slug',
        'name',
        'description',
        'price',
        'stock',
        'is_active',
        'published_at',
    ];

    public $casts = [
        'id' => 'string',
        'slug' => 'string',
        'name' => 'string',
        'description' => 'string',
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope('publishedAndActive', function (Builder $builder) {
            $builder->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->latest();
        });
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(isset($filters['name']), function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['is_active']), function ($q) use ($filters) {
                $q->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
            })
            ->when(isset($filters['min_price']), function ($q) use ($filters) {
                $q->where('price', '>=', $filters['min_price']);
            })
            ->when(isset($filters['max_price']), function ($q) use ($filters) {
                $q->where('price', '<=', $filters['max_price']);
            })
            ->when(isset($filters['min_stock']), function ($q) use ($filters) {
                $q->where('stock', '>=', $filters['min_stock']);
            })
            ->when(isset($filters['max_stock']), function ($q) use ($filters) {
                $q->where('stock', '<=', $filters['max_stock']);
            });
    }
}
