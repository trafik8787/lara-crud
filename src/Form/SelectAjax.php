<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 02.07.19
 * Time: 15:48
 */

namespace Trafik8787\LaraCrud\Form;


/**
 * Class SelectAjax
 * @package Trafik8787\LaraCrud\Form
 */
class SelectAjax
{
    protected $model;
    protected $field;
    protected $request;
    protected $dataField;
    protected $limit = 10;
    protected $data;
    protected $showFaild = [];
    protected $mask;
    protected $lastSearch = '%';
    protected $firstSearch = '';


    /**
     * SelectAjax constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * % в конце
     */
    public function lastSearch()
    {
        $this->lastSearch = '%';
        return $this;
    }

    /**
     * % в начале
     */
    public function firstSearch()
    {
        $this->firstSearch = '%';
        return $this;
    }

    /**
     * @param $model
     * @param $dataField
     * @return $this
     * передаем модель таблицы из которой будет выборка и масив полей
     */
    public function setData ($model, $dataField)
    {
        $this->model = $model;
        $this->dataField = $dataField;

        return $this;
    }

    /**
     * получаем модель данных для отдельных полей
     */
    private function getData()
    {

        $arrField = array_merge([$this->dataField['id'], $this->dataField['select']], $this->showFaild);

        if (!empty($this->request['term'])) {

            $model = $this->model->where($this->dataField['select'], 'like', $this->getMask($this->request['term']))
                ->limit($this->limit);

        } else {

            $model = $this->model->limit($this->limit);
        }

        $this->field[$this->request['field']] = $model->select($arrField)->get()->toArray();
    }

    /**
     * @param $field
     * @return $this
     * определяем поле по которому ведется выборка
     */
    public function set($field)
    {
        $this->field[$field];
        return $this;
    }

    /**
     * @param $field
     * принимает масив полей нужен для переопределения списка вывода в селекте по умолчанию
     */
    public function show($field)
    {
        $this->showFaild = $field;
    }


    /**
     * @param $objClassSelectAjax
     * @param $valueModel
     * @return array
     * получаем текущую запись для селекта
     */
    public function getCurentValue($objClassSelectAjax, $valueModel)
    {
        $curentSelect = $objClassSelectAjax['model']
            ->where($objClassSelectAjax['id'], $valueModel)
            ->first();

        $arr = [];
        if (!empty($curentSelect)) {

            $ajaxCurrentText = $curentSelect->{$objClassSelectAjax['select']};

            if (!empty($this->showFaild)) {
                $ajaxCurrentText = null;
                foreach ($this->showFaild as $item) {
                    $ajaxCurrentText .= ' '.$curentSelect->{$item};
                }
            }

            $arr['ajaxCurentValue'] = $valueModel;
            $arr['ajaxCurrentText'] = $ajaxCurrentText;
        }

        return $arr;
    }

    /**
     * @return false|string
     *
     */
    public function getJson()
    {
        $this->getData();

        $new_data = [];

        foreach ($this->field[$this->request['field']] as $item) {
            $new_data[] = [
                'id' => [$item[$this->dataField['id']]],
                'text' => $this->getText($item)
            ];
        }

        return json_encode(['results' => $new_data]);
    }


    /**
     * @param $data
     * @return string
     * метод формирует строку для вывода в селект
     */
    private function getText($data)
    {
        $text = $data[$this->dataField['select']];

        if (!empty($this->showFaild)) {

            $text = null;

            foreach ($this->showFaild as $item) {
                $text .= ' '.$data[$item];
            }
        }

        return strip_tags($text);
    }

    /**
     * @param int $count
     * количество которое выводится по умолчанию в селекте
     */
    public function limit ($count = 10)
    {
        $this->limit = $count;
    }

    /**
     * @param string $string
     * @return string
     */
    private function getMask($string = '')
    {
        return (string) $this->firstSearch . $string . $this->lastSearch;
    }
}