<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\IOrder;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository implements IOrder
{
    protected $builder;

    protected $model;

    public function __construct(Order $model)
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
        return $this->getQueryBuilder()->with([
                'customer',
                'orderItems'
            ])->get($columns);
    }

    public function findOrFail($id)
    {
        return $this->getQueryBuilder()->with([
                'customer',
                'orderItems',
                'orderItems.product',
            ])->findOrfail($id);
    }

    public function searchOrder($id)
    {
        return $this->getQueryBuilder()->where('id', $id)->with([
                'customer',
                'orderItems'
            ])->get();
    }

    public function create($data)
    {
        return $this->getQueryBuilder()->create($data);
    }

    public function delete($id)
    {
        $model = $this->findOrFail($id);

        $model->delete();

        return $model;
    }
}