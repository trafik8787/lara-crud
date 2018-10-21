<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 28.08.2017
 * Time: 20:26
 */

namespace Trafik8787\LaraCrud\Models;

use Closure;
use Request;
use Illuminate\View\View;
use Trafik8787\LaraCrud\Table\ChildRows;

class NodeModelConfiguration extends NodeModelConfigurationManager
{


    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * @param $url
     */
    public function url($url)
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
    public function buttonDelete(bool $value = true)
    {
        $this->buttonDelete = $value;
    }

    /**
     * @param bool $value
     * Enable/Disable button Apply in form
     */
    public function buttonApply(bool $value = true)
    {
        $this->buttonApply = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonAdd(bool $value = true)
    {
        $this->buttonAdd = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonCopy(bool $value = true)
    {
        $this->buttonCopy = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonGroupDelete(bool $value = true)
    {
        $this->buttonGroupDelete = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonEdit(bool $value = true)
    {
        $this->buttonEdit = $value;
    }

    /**
     * @param array $value
     */
    public function fieldShow(array $value)
    {
        $this->fieldShow = $value;
    }

    /**
     * @param $name
     * todo групировка полей по вкладкам проект!!
     */
    public function tab($name, array $field)
    {
        $this->tab[$name] = $field;
    }

    /**
     * @param string $field
     * @param int $limit
     * todo определить сокращение текста в конкретных полях и лимит символов
     */
    public function textLimit(string $field, int $limit)
    {

        if (is_array($field)) {
            $this->textLimit = $field;
        } else {
            $this->textLimit[$field] = $limit;
        }
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
    public function showEntries(int $count)
    {
        $this->showEntries = $count;
    }


    /**
     * @param $field
     * @param $operator
     * @param $value
     */
    public function setWhere($field, $operator, $value)
    {
        $this->setWhere = func_get_args();
    }

    /**
     * @param Closure $closure
     */
    public function setModelCollback(Closure $closure)
    {
        $this->setModelCollback = $closure;
    }

    /**
     * @param Closure $closure
     */
    public function tableRowsRenderCollback(Closure $closure)
    {
        $this->closureRowsRender = $closure;

    }

    public function beforeShowFormCollback(Closure $closure)
    {
        $this->closureShowFormCollback = $closure;
    }

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @param $color
     * todo цвета строкам по условию
     */
    public function columnColorWhere($field, $operator, $value, $color)
    {
        $this->columnColorWhere[] = func_get_args();
    }

    /**
     * @param $nameButtonAction
     * @param $url
     * @param Closure $closure |string
     * todo добавляет действия над записями в виде кнопок
     */
    public function addAction($nameButtonAction, $url, $closure)
    {

        if (is_object($closure)) {
            $this->newAction[$url] = [
                'nameButton' => $nameButtonAction,
                'closure' => $closure
            ];
        } elseif (is_string($closure)) {
            $this->newAction[$url] = [
                'nameButton' => $nameButtonAction,
                'action' => $closure
            ];
        }
    }


    /**
     * @param $funk
     * todo хук после обновления
     */
    public function afterUpdate($funk)
    {

        $model = $this->getModelObj();
        $model::updated($funk);
    }

    /**
     * @param Closure $closure
     */
    public function _afterUpdate(Closure $closure)
    {
        $this->_afterUpdate = $closure;
    }

    /**
     * @param $funk
     * todo хук перед обновлением
     */
    public function beforeUpdate($funk)
    {

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
    public function beforeDelete($funk)
    {
        $model = $this->getModelObj();
        $model::deleting($funk);
    }

    /**
     * @param $funk
     * todo хук после удаления
     */
    public function afterDelete($funk)
    {
        $model = $this->getModelObj();
        $model::deleted($funk);
    }


    /**
     * @param array $arrTypeField
     * todo выбор поля который будет отображатся в форме например input select file с настройками
     *
     */
    public function setTypeField(array $arrTypeField)
    {
        foreach ($arrTypeField as $nameField => $item) {
            if (is_array($item)) {

                //проверяем подключена ли к полю другая таблица
                if (!empty($item[3]) and $item[2] === 'multiple') {
                    $this->setOtherTable($nameField, $item[3]);
                }

                if (!empty($item[3]) and $item[2] === 'one-to-one') {
                    $this->setOtherTable($nameField, $item[3]);
                }

                if (!empty($item[3]) and $item[2] === 'one-to-many') {
                    $this->setOneToMany($nameField, $item[3]);
                }



                switch ($item[0]) {
                    case 'file':
                        $this->setFileUploadSeting($nameField, $item);
                        break;
                    case 'select':
                        //проверяем если класс
                        if (isset($item[1][0])) {
                            //можем передать имя класса или обьект модели
                            if (is_object($item[1][0])) {
                                $this->modelTableSelect = $item[1][0];
                            } elseif (class_exists($item[1][0])) {
                                $this->modelTableSelect = $this->app->make($item[1][0]);
                            }

                            $this->objClassSelectAjax[$nameField] = [
                                'id' => $item[1][1],
                                'select' => $item[1][2],
                                'model' => $this->modelTableSelect
                            ];
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
    public function addFieldClass(array $arr)
    {
        $this->addFieldClass = $arr;
    }

    /**
     * @param array $arr
     * todo добавляет title полю ввода
     */
    public function addFieldTitle(array $arr)
    {
        $this->addFieldTitle = $arr;
    }

    /**
     * @param array $arr
     * todo добавляет Placeholder полю ввода
     */
    public function addFieldPlaceholder(array $arr)
    {
        $this->addFieldPlaceholder = $arr;
    }


    /**
     * @param null $id
     * todo метод определяет тип вывода если обьевлен форма редактирования виводится сразу может принимать id строки в таблице
     */
    public function formShow($id = null)
    {
        $this->formShowId = 1;
        if ($id !== null) {
            $this->formShowId = $id;
        }
    }


    /**
     * @param array $field
     */
    public function enableEditor(array $field)
    {
        $this->enableEditor = $field;
    }

    /**
     * @param $data
     * todo таблица в которую добавляются записи многие ко многим
     */
    public function setOtherTable($nameField, $data)
    {
        //проверяем масив ли это не пустой ли он и соотвецтвует ли критериям
        if (!empty($data) and is_array($data) and class_exists($data[0])) {

            $this->OtherTable[$nameField] = [
                'model' => $this->app->make($data[0]),
                'ralation_table' => $data[1], //таблица отношения многие ко многим
                'foreign_key' => $data[2],
                'local_key' => $data[3]
            ];

            return $this->OtherTable;
        }

        return false;
    }

    /**
     * @param array $dataArr
     */
    public function Tooltip(array $dataArr)
    {
        $this->tooltip = $dataArr;
    }

    /**
     * @param array $dataArr
     */
    public function Validation(array $dataArr, array $messages = [])
    {
        $this->validation = $dataArr;
        $this->validation_messages = $messages;
    }


    /**
     * @param $data
     * todo данные для полей один ко многим
     */
    public function setOneToMany($nameField, $data)
    {

        if (class_exists($data[0])) {
            $this->fieldOneToMany[$nameField] = [
                'model' => $data[0],
                'list_fields' => isset($data[1]) ? $data[1] : null,
                'foreign_key' => isset($data[2]) ? $data[2] : null,
                'local_key' => isset($data[3]) ? $data[3] : null

            ];
        }

    }

    /**
     * @param $view
     * //кастомный вывод
     */
    public function renderCustom($view)
    {
        $this->view = $view;
    }


    /**
     * @param array|string|null $msg
     */
    public function alertDelete($msg = 'Are you sure you want to delete?', $event = 'onsubmit', $func = 'confirmDelete')
    {
        $this->alertDelete = [
            'msg' => $msg,
            'event' => $event,
            'func' => $func
        ];
    }

    /**
     * @param Closure|null $closure
     */
    public function showChildRows(Closure $closure = null)
    {

        $this->showChildRowsClass = new ChildRows(Request::input(), $closure);


        return $this->showChildRowsClass;
    }

    /**
     * @param Closure|null $closure
     */
    public function ajaxBeforeLoadSelect(Closure $closure = null)
    {
        $this->ajaxBeforeLoadSelect = $closure;
    }

    /**
     * @param array $arrField
     */
    public function setDefaultSelected(array $arrField)
    {
        $this->arrField = $arrField;
    }

    /**
     * @param Closure $closure
     */
    public function addViewsCustomTop(Closure $closure)
    {
        $this->addViewsCustomTop = $closure;
    }

    /**
     * @param string $class
     */
    public function setClassForm(string $class)
    {
        $this->setClassForm = $class;
    }

    /**
     * @param array $arrField
     */
    public function fieldAttribute (array $arrField)
    {
        $this->fieldAttribute = $arrField;
    }

    /**
     * @param array $arrField
     */
    public function setValueDefault(array $arrField)
    {
        $this->setValue = $arrField;
    }

    /**
     * @param array $nameArr
     */
    public function fieldOrderByDisable(array $nameArr)
    {
        $this->fieldOrderByDisable = $nameArr;
    }


    /**
     * @param string $field
     */
    public function enableDragAndDrop(string $field)
    {
        $this->enableDragAndDrop = $field;
    }

    /**
     * @param array $field
     */
    public function setOrderFixed(array $field)
    {
        $this->setOrderFixed = $field;
    }

    /**
     * @param array $field
     */
    public function fieldDisable (array $field)
    {
        $this->fieldDisable = $field;
    }
}













