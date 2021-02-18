<?php


namespace App\Helpers;

use Illuminate\Support\Arr;

class ListingHelper
{
    private $defaultPerPage;
    private $defaultSortBy;
    private $defaultSearchField;
    private $requiredConditions;

    public function __construct($sortBy = 'desc', $perPage = 10, $searchField = 'updated_at', $requiredConditions = [])
    {
        $this->defaultSortBy = $sortBy;
        $this->defaultPerPage = $perPage;
        $this->defaultSearchField = $searchField;
        $this->requiredConditions = $requiredConditions;
    }

    // $model = Model class of the listing page. Ex. User::class
    // $searchFields = Fields in the table that wants to be search. The keys should same with sa database column name. Ex. ['id', 'first_name']
    // $customerQuery = We are using orWhereRaw for the query so you can use Database function. Ex. ["CONCAT(`first_name`, ' ', CONCAT(LEFT(`middle_name`,1),'.'), ' ', `last_name`, ' ', `ext_name`) LIKE ?"]
    // $customerQueryFields = Fields that in the $searchFields and used in $customQuery. Ex. ['first_name']
    public function simple_search($model, $searchFields, $customQuery = [], $customQueryFields = [], $joinTables = [], $selectFields = [])
    {
        $sortFields =  (empty($this->filterFields)) ? $searchFields : $this->filterFields;

        $perPage = $this->get_count_per_page();
        $orderBy = $this->get_selected_order_by($sortFields);
        $sortBy = $this->get_selected_sort_by();
        $showDeleted = $this->show_delete_data();
        $search =  $this->get_search_string();

        if (empty($selectFields)) {
            $models = $model::orderBy($orderBy, $sortBy);
        } else {
            $models = $model::select($selectFields)->orderBy($orderBy, $sortBy);
        }

        foreach ($joinTables as $table) {
            $models->leftJoin($table['name'], $table['field1'], $table['field2']);
        }

        if ($showDeleted) {
            $models->withTrashed();
        }

        foreach ($this->requiredConditions as $condition) {
            if ($showDeleted && $condition['apply_to_deleted_data'] == false) {
                continue;
            }

            $models->where($condition['field'], $condition['operator'], $condition['value']);
        }

        $models->where(function($models) use ($search, $searchFields, $customQuery, $customQueryFields) {
            foreach ($searchFields as $fieldName) {
                if (in_array($fieldName, $customQueryFields) <= -1) {
                    $models->orWhere($fieldName, 'like', '%' . $search . '%');
                }
            }

            foreach ($customQuery as $query) {
                $models->orWhereRaw($query, ['%' . $search . '%']);
            }
        });

        return $models->paginate($perPage);
    }

    // $model = Model class of the listing page. Ex. User::class
    // $searchFields = Fields in the advance search form. The keys should same with sa database column name. Ex. ['id', 'first_name']
    // $equalSearchFields = Fields that use equal in condition
    public function advance_search($model, $searchFields, $equalSearchFields)
    {
        $searchFields = $this->get_search_filtered($searchFields);

        $perPage = $this->get_count_per_page();
        $orderBy = $this->get_selected_order_by($searchFields);
        $sortBy = $this->get_selected_sort_by();
        $showDeleted = $this->show_delete_data();

        if ($showDeleted) {
            $queryBuilder = $model::withTrashed();
        } else {
            $queryBuilder = $model::whereNotNull('id');
        }

        foreach ($equalSearchFields as $fieldName) {
            if (isset($searchFields['created_at1'])) {
                $queryBuilder->where('created_at', '>=', $searchFields['created_at1']);

                unset($searchFields['created_at1']);
            } elseif (isset($searchFields['created_at2'])) {
                $queryBuilder->where('created_at', '<=', $searchFields['created_at2'].' 23:59:59');

                unset($searchFields['created_at2']);
            } else if (isset($searchFields['updated_at1'])) {
                $queryBuilder->where('updated_at', '>=', $searchFields['updated_at1']);

                unset($searchFields['updated_at1']);
            } elseif (isset($searchFields['updated_at2'])) {
                $queryBuilder->where('updated_at', '<=', $searchFields['updated_at2'].' 23:59:59');

                unset($searchFields['updated_at2']);
             } else if (isset($searchFields['price1'])) {
                $queryBuilder->where('price', '>=', $searchFields['price1']);

                unset($searchFields['price1']);
            } elseif (isset($searchFields['price2'])) {
                $queryBuilder->where('price', '<=', $searchFields['price2']);

                unset($searchFields['price2']);
            } else {
                if (isset($searchFields[$fieldName])) {
                    $field_value = $searchFields[$fieldName];

                    if ($field_value == '#^!!') {
                        $queryBuilder->whereNull($fieldName);
                        unset($searchFields[$fieldName]);
                    } else {
                        $queryBuilder->where($fieldName, $field_value);
                        unset($searchFields[$fieldName]);
                    }


                }
            }
        }

        foreach ($searchFields as $fieldName => $field_value) {
            if ($field_value == '#^!!') {
                $queryBuilder->whereNull($fieldName);
                continue;
            }
            $queryBuilder->where($fieldName, 'like', '%'.$field_value.'%');
        }

        return $queryBuilder->orderBy($orderBy, $sortBy)->paginate($perPage);
    }

    public function get_unique_item_by_column($model, $columnName)
    {
        if ($this->show_delete_data()) {
            return $model::withTrashed()->orderBy($columnName, 'ASC')->get()->unique($columnName)->values()->all();
        } else {
            return $model::orderBy($columnName, 'ASC')->get()->unique($columnName)->values()->all();
        }
    }

    public function get_filter($searchFields)
    {
        $parameters = request()->all();
        $parameters['perPage'] = $this->get_count_per_page();
        $parameters['orderBy'] = $this->get_selected_order_by($searchFields);
        $parameters['sortBy'] = $this->get_selected_sort_by();
        $parameters['showDeleted'] = $this->show_delete_data();
        $parameters['search'] = $this->get_search_string();

        return (object) $parameters;
    }

    public function get_search_filtered($searchFields)
    {
        return array_filter($this->credentials($searchFields), function ($value, $key) {
            return $value != null && $key != '_token';
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function get_search_data($searchFields)
    {
        $arrayData = array_map(function ($key) {
            if (request()->has($key) && request()->$key != null) {
                return [$key => request()->$key];
            } else {
                return[$key => ''];
            }
        }, $searchFields);

        $searchData = [];
        foreach ($arrayData as $data) {
            $searchData[key($data)] = $data[key($data)];
        }

        return (object) $searchData;
    }

    private function credentials($searhFields)
    {
        return request()->only($searhFields);
    }

    private function get_count_per_page()
    {
        $perPage = request()->has('perPage') && is_numeric(request('perPage')) ? request('perPage') : $this->defaultPerPage;
        return ($perPage > 100) ? 100 : $perPage;
    }

    private function get_selected_order_by($searchFields)
    {
        return request()->has('orderBy') && in_array(request('orderBy'), $searchFields) ? request('orderBy') : $this->defaultSearchField;
    }

    private function get_selected_sort_by()
    {
        $sortBy = request('sortBy') ?? $this->defaultSortBy;
        return $sortBy == 'asc' ? 'asc' : 'desc';
    }

    private function get_search_string()
    {
        return request('search') ?? '';
    }

    private function show_delete_data()
    {
        return (request()->has('showDeleted') && (request('showDeleted') == 'on') || request('showDeleted') == 1) ? true : false;
    }
}
