<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    const LIMIT = 30;

    const OFFSET = 0;

    const OPERATOR_WHERE = 'where';

    const OPERATOR_WHERE_BETWEEN = 'between';

    const OPERATOR_WHERE_NOT_IN = 'where_not_in';

    const OPERATOR_WHERE_IN = 'where_in';

    protected $model;
    protected $tableName;

    public function __construct(?array $params = [])
    {
        $this->model = app()->make($this->getModel());
        $this->tableName = $this->model->getTable();
        if (!empty($params)) {
            $this->model = $this->baseQuery($params);
        }
    }

    /**
     * Get Count itemm by conditions
     *
     * @param array $conditions
     * @return int
     */
    public function getCountWithConditions(array $conditions = []): int
    {
        if (empty($conditions)) {
            return $this->model->count();
        }

        return $this->model->where(...$conditions)->count();
    }

    public function getByPKs($ids = [])
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->get();
    }

    public function get($order = [], $with = [])
    {
        return $this->model->get();
    }

    /**
     * Update model by primary key on data update
     *
     * @param int|Model model It's int primary key or Model
     * @param  array  $update  Data update to model
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function updateByPK(int|Model|null $model = null, array $update = [])
    {
        if ($model instanceof Model) {
            return $model->update($update);
        }

        return $this->model->find($model)->update($update);
    }

    /**
     * Update model by primary key on data update
     *
     * @param int|Model model It's int primary key or Model
     * @param  array  $update  Data update to model
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function updateByPKs(array $ids = [], array $update = [])
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->update($update);
    }

    /**
     * Create or update model by conditions on data attributes
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $conditions = [], array $attributes = [])
    {
        return $this->model->updateOrCreate($conditions, $attributes);
    }

    /**
     * Create model by attributes
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Create model by attributes
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function insert(array $attributes = [])
    {
        return $this->model->insert($attributes);
    }

    /**
     * Get model by id primary key
     *
     * @return bool|Illuminate\Database\Eloquent\Model|mixed
     */
    public function getByPK(?int $id = null)
    {
        if (empty($id)) {
            return false;
        }

        return $this->model->find($id);
    }

    /**
     * Get one data with multi conditions
     */
    public function getFirstWithConditions(...$parameters)
    {
        return $this->model->where(function ($query) use ($parameters) {
            foreach ($parameters as $parameter) {
                $query->where($parameter);
            }
        })->first();
    }

    /**
     * Check has exists with multi conditions
     */
    public function exists($parameters)
    {
        return $this->baseQuery($parameters)->exists();
    }

    public function paginate($parameters = [], $orders = [], $with = [], $per_page = 30)
    {
        if (empty($orders)) {
            $orders = [$this->model->getKeyName() => config('constant_view.QUERY_DATABASE.DESC')];
        }

        $query = $this->baseQuery($parameters);

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $query->orderBy(...$order);
            }
        }

        $per_page = request('per_page', $per_page);

        if ($with) {
            $query->with($with);
        }

        return $query->paginate($per_page);
    }

    /**
     * Get list data with multi conditions
     */
    public function getListWithConditions($parameters = [], $orders = [], $with = [])
    {
        $query = $this->baseQuery($parameters);

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $query->orderBy(...$order);
            }
        }

        if ($with) {
            $query->with($with);
        }

        return $query->get();
    }

    private function baseQuery($multi_conditions)
    {
        return $this->model->where(function ($query) use ($multi_conditions) {
            foreach ($multi_conditions as $method => $conditions) {
                foreach ($conditions as $condition) {
                    if (is_callable($condition)) {
                        $query->{$method}($condition);
                    } else {
                        $query->{$method}(...$condition);
                    }
                }
            }
        });
    }

    /**
     * Count data with multi conditions
     */
    public function countWithConditions($parameters)
    {
        return $this->baseQuery($parameters)->count();
    }

    /**
     * Paginate data with multi conditions
     */
    public function paginateWithConditions($page, $limit, $orders = [], $parameters)
    {
        $page = $page ?? self::OFFSET;
        $limit = $limit ?? self::LIMIT;

        $query = $this->baseQuery($parameters);

        if (func_num_args() > 3 && !empty($orders)) {
            foreach ($orders as $order) {
                $query->orderBy(...$order);
            }
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    /** Delete model by id primary key
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function deleteByPK(?int $id = null)
    {
        if (empty($id)) {
            return false;
        }

        return $this->model->destroy($id);
    }

    /**
     * Get list model has paginate by per item on page
     *
     * @param int per_page number item on page
     * @param array conditions conditions handle query.
     * [
     *      'where' => ['column', 'a'] || [['column', 'a'], ['column', 'b']],
     *      'between' => ['column', ['a', 'b']] || [['column', ['a', 'b']], ['column', ['b', 'c']]],
     *      'where_not_in' => ['column', ['a', 'b', 'c', ...]] || [['column', ['a', 'b', ...]], ['column', ['b', 'c', ...]]],
     *      'where_in' => ['column', ['a', 'b', 'c', ...]] || [['column', ['a', 'b', ...]], ['column', ['b', 'c', ...]]],
     * ] OR ['column', 'a']
     * @param array $with relationship model
     * @param array field_sort List model sort by field.
     * ['column', 'ASC' OR 'DESC'] OR [['column', 'ASC' OR 'DESC'], ['column', 'ASC' OR 'DESC'], ...]
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginate(
        int $per_page = 30,
        array $conditions = [],
        array $with = [],
        array $field_sort = []

    ) {
        $query = $this->handleModelSort($this->model, $field_sort)->with($with);

        if (!$this->checkKeyConditions(array_keys($conditions))) {
            return $this->handleModelWhere($query, $conditions)->paginate($per_page);
        }
        return $query->where(function ($query_child) use ($conditions) {
            if ($where = data_get($conditions, self::OPERATOR_WHERE, [])) {
                $query_child = $this->handleModelWhere($query_child, $where);
            }
            if ($where_between = data_get($conditions, self::OPERATOR_WHERE_BETWEEN, [])) {
                $query_child = $this->handleModelWhereBetween($query_child, $where_between);
            }
            if ($where_not_in = data_get($conditions, self::OPERATOR_WHERE_NOT_IN, [])) {
                $query_child = $this->handleModelWhereNotIn($query_child, $where_not_in);
            }
            if ($where_in = data_get($conditions, self::OPERATOR_WHERE_IN, [])) {
                $query_child = $this->handleModelWhereIn($query_child, $where_in);
            }
        })->paginate($per_page);
    }

    /**
     * Delete multiple models by IDs
     *
     * @return int
     */
    public function deleteMultiple(array $ids)
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->delete();
    }

    /**
     * Get path model class
     */
    abstract protected function getModel(): string;

    /**
     * -------------------------------------PRIVATE FUNCTION-------------------------------------
     */

    /**
     * Check key in array key of conditions
     *
     * @param  $keys  list key in conditions;
     * @return bool
     */
    private function checkKeyConditions(array $keys = [])
    {
        if (empty($keys)) {
            return false;
        }

        return in_array(self::OPERATOR_WHERE, $keys) ||
            in_array(self::OPERATOR_WHERE_BETWEEN, $keys) ||
            in_array(self::OPERATOR_WHERE_NOT_IN, $keys) ||
            in_array(self::OPERATOR_WHERE_IN, $keys);
    }

    /**
     * Handle query conditions for model use function where
     *
     * @param  mixed  $query
     * @return mixed
     */
    private function handleModelWhere($query, array $conditions = [])
    {
        if (empty($conditions)) {
            return $query;
        }

        foreach ($conditions as $condition) {
            if (!is_array($condition)) {
                $query = $query->where(...$conditions);
                break;
            }
            $query = $query->where(...$condition);
        }
        return $query;
    }

    /**
     * Handle query conditions for model use function whereIn
     *
     * @param  mixed  $query
     * @return mixed
     */
    private function handleModelWhereIn($query, array $conditions = [])
    {
        if (empty($conditions)) {
            return $query;
        }

        foreach ($conditions as $condition) {
            if (!is_array($condition)) {
                $query = $query->whereIn(...$conditions);
                break;
            }
            $query = $query->whereIn(...$condition);
        }
        return $query;
    }

    /**
     * Handle query conditions for model use function whereBetween
     *
     * @param  mixed  $query
     * @return mixed
     */
    private function handleModelWhereBetween($query, array $conditions = [])
    {
        if (empty($conditions)) {
            return $query;
        }

        foreach ($conditions as $condition) {
            if (!is_array($condition)) {
                $query = $query->whereBetween(...$conditions);
                break;
            }
            $query = $query->whereBetween(...$condition);
        }
        return $query;
    }

    /**
     * Handle query conditions for model use function whereNotIn
     *
     * @param  mixed  $query
     * @return mixed
     */
    private function handleModelWhereNotIn($query, array $conditions = [])
    {
        if (empty($conditions)) {
            return $query;
        }

        foreach ($conditions as $condition) {
            if (!is_array($condition)) {
                $query = $query->whereNotIn(...$conditions);
                break;
            }
            $query = $query->whereNotIn(...$condition);
        }
        return $query;
    }

    /**
     * Handle model sort item when completed query model where
     *
     * @param  mixed  $query
     * @return mixed
     */
    private function handleModelSort($query, array $field_sort = [])
    {
        if (empty($field_sort)) {
            return $query->orderBy($this->model->getKeyName(), config('constant_view.QUERY_DATABASE.DESC'));
        }
        foreach ($field_sort as $field) {
            if (!is_array($field)) {
                $query = $query->orderBy(...$field_sort);
                break;
            }
            $query = $query->orderBy(...$field);
        }

        return $query;
    }

    /**
     * Check exists and create model by conditions on data attributes
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */

    public function existsAndCreate($parameters, $attributes)
    {
        if ($this->exists($parameters)) {
            return false;
        }

        return $this->create($attributes);
    }

    public function countByDate($field, $date, bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->whereDate($field, $date)
            ->whereYear($field, $year)
            ->whereMonth($field, $month);
        if ($is_day) {
            $query->whereDay($field, $day);
        }
        return $query->count();
    }

    public function partnerChilds()
    {
        $arr = $this->arrChildren();
        if (empty($arr)) {
            return ['whereNull' => [['mID']]];
        }

        return ['whereIn' => [['mID', $arr]]];
    }

    public function arrChildren()
    {
        if (empty(auth('partner')->user())) return [];

        $arr = auth('partner')->user()->children->pluck('mID')->toArray();
        if (empty($arr)) {
            return [];
        }

        return $arr;
    }
}
