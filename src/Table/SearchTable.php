<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 10.06.19
 * Time: 17:11
 */

namespace Trafik8787\LaraCrud\Table;


class SearchTable
{

    protected $mask;
    protected $lastSearch = '%';
    protected $firstSearch = '%';
    protected $fieldSearch = [];

    /**
     * % в конце
     */
    public function lastSearch()
    {
        $this->lastSearch = '%';
        $this->firstSearch = '';
    }

    /**
     * % в начале
     */
    public function firstSearch()
    {
        $this->firstSearch = '%';
        $this->lastSearch = '';
    }

    /**
     * без %
     */
    public function exactSearch()
    {
        $this->firstSearch = '';
        $this->lastSearch = '';
    }

    /**
     * @param array $fields
     * @return $this
     * поля по каким ведется поиск
     */
    public function fieldSearch($fields = [])
    {
        $this->fieldSearch = $fields;
        return $this;
    }

    /**
     * @param $model
     * @param $fields
     * @param string $searchValue
     * @return mixed
     * пелучает обьект модели
     */
    public function setSearch($model, $fields, $searchValue = '')
    {

        if (!empty($this->fieldSearch)) {
            $fields = array_intersect ($this->fieldSearch, $fields);
        }

        $model->where(function ($query) use ($fields, $searchValue) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', $this->getMask($searchValue));
            }
        });

        return $model;
    }

    /**
     * @param string $string
     * @return string
     * получае маску поиска
     */
    public function getMask($string = '')
    {

        return (string) $this->firstSearch . $string . $this->lastSearch;

    }

}