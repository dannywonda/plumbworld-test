<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class Repository
{
    protected Model $model;

    public const PAGINATE = 12;

    /**
     * @throws BindingResolutionException
     */
    public function __construct(protected Container $app)
    {
        $this->makeModel();
    }

    /**
     * Define the model class to be used.
     */
    abstract public function model(): string;
 

    public function all(Request $request): LengthAwarePaginator
    {
        return $this->model::query()
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
    }

    /**
     * Create a new model instance.
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Delete a model record.
     *
     * @param  Model  $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Update an existing model record.
     *
     * @param  array  $data
     * @param  Model  $model
     * @return Model
     */
    public function update(array $data, Model $model): Model
    {
        $model->update($data);
        return $model;
    }

    /**
     * Instantiate the model.
     *
     * @throws BindingResolutionException
     */
    protected function makeModel(): void
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \RuntimeException("Class {$this->model()} must be an instance of " . Model::class);
        }

        $this->model = $model;
    }
}