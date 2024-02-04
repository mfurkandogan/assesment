<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\IProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements IProduct
{
    protected $builder;

    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return $this->model;
    }

    public function getQueryBuilder()
    {
        return $this->builder = $this->model()::query();
    }

    public function setQueryBuilder(Builder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    public function all($columns = ['*'])
    {
        return $this->getQueryBuilder()->get($columns);
    }

    public function find($id)
    {
        return $this->getQueryBuilder()->findOrfail($id);
    }

    public function create($data)
    {
        return $this->getQueryBuilder()->create($data);
    }

    public function update($data, $id)
    {
        $model = $this->find($id);

        $model->update(["quantity"=>$data]);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        $model->delete();

        return $model;
    }
}