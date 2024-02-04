<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface IProduct
{
    /**
     * @return mixed
     */
    public function model();

    /**
     * @return mixed
     */
    public function getQueryBuilder();

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function setQueryBuilder(Builder $builder);

    /**
     * @param $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}