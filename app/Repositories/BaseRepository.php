<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model as Model;
use DB;
use Config;

/*****************************************************************************
 * Base repository
 ****************************************************************************
 * This is base repository
 * Status: Not yet complete
 **************************************************************************
 * @author: Tran Thien Nhan
 ****************************************************************************/
class BaseRepository
{

    /**
     * The Model name.
     *
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    /**
     * The Primary Key of table
     * need to override in case the Primary key is not ID
     * if not set some function will not work at property
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $primary_key;

    public $remember_token = false;

    public function __construct()
    {
        $this->model = new Model();
        $this->primary_key = 'id';
        set_time_limit(0);
    }

    /**
     * Paginate the given query.
     *
     * @param The number of models to return for pagination $n integer
     *
     * @return mixed
     */
    public function getPaginate($n)
    {
        return $this->model->paginate($n);
    }

    /**
     * Range records the given query.
     *
     * @param The number of models to return for index
     *
     * @return mixed
     */
    public function getRange($whereClause, $startIndex, $number, $orderBy = 'id', $orderType = 'ASC')
    {
        $model = $this->model;
        if ($whereClause != null && count($whereClause) != 0) {
            $model = $model->where($whereClause);
        }
        if ($startIndex !== null && $number !== null) {
            $model = $model->take($number)->skip($startIndex);
        }
        if ($orderBy != null && $orderType != null) {
            $model = $model->orderBy($orderBy, $orderType);
        }
        return $model->get();
    }

    /**
     * Create a new model and return the instance.
     *
     * @param array $inputs
     *
     * @return Model instance
     */
    public function store(array $inputs)
    {
        return $this->model->create($inputs);
    }

    /**
     * Get all record
     *
     * @param
     *
     * @return Model instance
     */
    public function getAll()
    {
        return $this->model->get();
    }

    /**
     * Get multiple record by ids
     *
     * @param
     *
     * @return Model instance
     */
    public function getMultiple($ids)
    {
        return $this->model->whereIn($this->primary_key, $ids)->get();
    }

    /**
     * Get record by like clause
     *
     * @param
     *
     * @return Model instance
     */
    public function getLike($column, $value)
    {
        return $this->getWhere([[$column, 'LIKE', '%' . $value . '%']]);
    }

    public function getFiled($filed, $value)
    {
        return $this->model->where($filed, $value)->get();
    }
    /**
     * FindOrFail Model and return the instance.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById($p_id)
    {
        return $this->model->find($p_id);
    }


    /**
     * return the instance with highest PrimaryKey
     *
     * @author Luan
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getLast()
    {
        $key = $this->primary_key;
        return $this->model->orderBy($key, 'DESC')->first();
    }

    /**
     * Paginate the given query by the condition given.
     * @author Luan
     * @param The number of models to return for pagination $n integer
     * @param the $p_where array of condition
     * @param the $order_by sort by
     * example Test_Repository->PaginateByWhere(15,['id'=>2],['id'=>ASC])
     * @return mixed
     */
    public function PaginateByWhere($n, array $p_where, $order_by = NULL, $sort_type = 'ASC')
    {
        foreach ($p_where as $key => $where) {
            if ($where == 'null') {
                $query = $this->model->whereNull($key);
            } elseif ($where == 'not null') {
                $query = $this->model->whereNotNull($key);
            } else {
                $query = $this->model->where($key, $where);
            }
        }
        if ($order_by != NULL) $query = $query->orderBy($order_by, $sort_type);
        return $query->paginate($n);
    }

    /**
     * Insert the model in the database.
     *
     * @param $id
     * @param array $inputs
     */
    public function insert($p_obj)
    {
        foreach ($p_obj as $key => $value) {
            $this->model->$key = $value;
        }
        $rs = false;
        try {
            $rs = $this->model->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = false;
            dd($e);
        }
        if ($rs == false)
            return false;
        return $this->model->id;
    }

    /**
     * Update the model in the database.
     *
     * @param $id
     * @param array $inputs
     */
    public function update($p_id, array $p_inputs)
    {
        return $this->getById($p_id)->update($p_inputs);
    }

    /**
     * Update the model in the database.
     *
     * @param $id
     * @param array $inputs
     */
    public function updateByWhere($p_where, array $p_inputs)
    {
        return $this->model->where($p_where)->update($p_inputs);
    }


    /**
     * Update or insert the model in the database.
     *
     * @param array $array_attributes
     * @param array $array_data
     */
    public function updateOrInsertData($array_attributes, $array_data)
    {
        return $this->model->updateOrInsert($array_attributes, $array_data);
    }

    /**
     * insert the model in the database.
     *
     * @param array $array_attributes
     * @param array $array_data
     */
    public function insertMutiData($array_data)
    {
        return $this->model->insert($array_data);
    }

    /**
     * Delete the model from the database.
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Delete the model from the database.
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function destroyByWhere($p_arr)
    {
        return $this->model->where($p_arr)->delete();
    }

    /**
     * Function getWhere
     * Truy vấn theo điều kiện
     * @param mảng các điều kiện
     * @return collection các kết quả
     * @access public
     */
    public function getWhere($conditions = false, $order_by = NULL, $sort_type = 'ASC')
    {
        if ($conditions) {
            $query =  $this->model->where($conditions);
        } else {
            $query =  $this->model;
        }

        if ($order_by != NULL) $query = $query->orderBy($order_by, $sort_type);

        return $query->get();
    }
    // where max field
    public function maxField($filed)
    {
        return $this->model->selectRaw("max($filed) as $filed")->get();
    }

    //sum by where
    //return a number
    public function sumByWhere($sumfield, $where_arr)
    {
        $query = $this->model->where($where_arr);
        $result = $query->sum($sumfield);
        return $result;
    }
}
