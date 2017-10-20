<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 28.08.2017
 * Time: 20:26
 */

namespace Trafik8787\LaraCrud\Models;

use Closure;

class NodeModelConfiguration extends NodeModelConfigurationManager
{


    /**
     * @param $title
     */
    public function setTitle ($title)
    {
        $this->title = $title;
    }


    /**
     * @param $url
     */
    public function url ($url)
    {
        $this->url = $url;
    }

    /**
     * @param array $field
     * todo добавление полям lable
     */
    public function fieldName(array $field)
    {
        $this->fieldName = $field;
    }
    /**
     * @param bool $value
     */
    public function buttonDelete (bool $value = true)
    {
        $this->buttonDelete = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonEdit (bool $value = true){
        $this->buttonEdit = $value;
    }

    /**
     * @param array $value
     */
    public function fieldShow(array $value){
        $this->fieldShow = $value;
    }

    /**
     * @param $name
     * todo групировка полей по вкладкам проект!!
     */
    public function tab ($name, array $field) {
        $this->tab[$name] = $field;
    }

    /**
     * @param string $field
     * @param int $limit
     * todo определить сокращение текста в конкретных полях и лимит символов
     */
    public function textLimit(string $field, int $limit) {
        $this->textLimit[$field] = $limit;
    }

    /**
     * @param int $field
     * @param string $sort
     */
    public function fieldOrderBy(int $field, string $sort)
    {
        $this->fieldOrderBy = [$field, $sort];
    }

    /**
     * @param int $count
     */
    public function showEntries (int $count)
    {
        $this->showEntries = $count;
    }


    /**
     * @param $field
     * @param $operator
     * @param $value
     */
    public function setWhere ($field, $operator, $value)
    {
        $this->setWhere = func_get_args();
    }


    /**
     * @param Closure $closure
     */
    public function tableRowsRenderCollback (Closure $closure)
    {
        $this->closure = $closure;

    }

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @param $color
     * todo цвета строкам по условию
     */
    public function columnColorWhere ($field, $operator, $value, $color)
    {
        $this->columnColorWhere[] = func_get_args();
    }

    /**
     * @param $nameButtonAction
     * @param $url
     * @param Closure $closure|string
     * todo добавляет действия над записями в виде кнопок
     */
    public function addAction ($nameButtonAction, $url, $closure)
    {

        if (is_object($closure)) {
            $this->newAction[$url] = [
                'nameButton' => $nameButtonAction,
                'closure'   => $closure
            ];
        } elseif (is_string($closure)) {
            $this->newAction[$url] = [
                'nameButton' => $nameButtonAction,
                'action'   => $closure
            ];
        }
    }


    /**
     * @param $funk
     * todo хук после обновления
     */
    public function afterUpdate ($funk) {

        $model = $this->getModelObj();
        $model::updated($funk);
    }

    /**
     * @param $funk
     * todo хук перед обновлением
     */
    public function beforeUpdate ($funk) {

        $model = $this->getModelObj();
        $model::updating($funk);
    }

    /**
     * @param $funk
     * todo хук перед добавлением
     */
    public function beforeInsert($funk)
    {
        $model = $this->getModelObj();
        $model::creating($funk);
    }

    /**
     * @param $funk
     * todo хук после добавления
     */
    public function afterInsert($funk)
    {
        $model = $this->getModelObj();
        $model::created($funk);
    }

    /**
     * @param $funk
     * todo хук перед удалением
     */
    public function beforeDelete ($funk)
    {
        $model = $this->getModelObj();
        $model::deleting($funk);
    }

    /**
     * @param $funk
     * todo хук после удаления
     */
    public function afterDelete ($funk)
    {
        $model = $this->getModelObj();
        $model::deleted($funk);
    }


    /**
     * @param array $arrTypeField
     * todo выбор поля который будет отображатся в форме например input select file с настройками
     *
     */
    public function setTypeField (array $arrTypeField)
    {
        foreach ($arrTypeField as $nameField => $item) {
            if (is_array($item)) {
                switch ($item[0]) {
                    case 'file':
                        $this->setFileUploadSeting($nameField, $item);
                        break;
                    case 'select':
                        if (isset($item[1][0]) and class_exists($item[1][0])) {
                            $this->objClassSelectAjax[$nameField] = ['id' => $item[1][1], 'select' => $item[1][2], 'model' => $this->app->make($item[1][0])];
                        }
                        break;
                }

            }
        }

        $this->setTypeField = $arrTypeField;
        return $this;
    }

    /**
     * @param array $arr
     * todo добавляем класс полю ввода
     */
    public function addFieldClass (array $arr)
    {
        $this->addFieldClass = $arr;
    }

    /**
     * @param array $arr
     * todo добавляет title полю ввода
     */
    public function addFieldTitle (array $arr)
    {
        $this->addFieldTitle = $arr;
    }

    /**
     * @param array $arr
     * todo добавляет Placeholder полю ввода
     */
    public function addFieldPlaceholder (array $arr)
    {
        $this->addFieldPlaceholder = $arr;
    }



    /**
     * @param null $id
     * todo метод определяет тип вывода если обьевлен форма редактирования виводится сразу может принимать id строки в таблице
     */
    public function formShow ($id = null)
    {
        $this->formShowId = 1;
        if ($id !== null) {
            $this->formShowId = $id;
        }
    }

    /**
     *
     */
    public function disableEditor ()
    {
        $this->disableEditor = func_get_args();
    }


}













