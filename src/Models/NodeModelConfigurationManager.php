<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 30.08.2017
 * Time: 22:43
 */

namespace Trafik8787\LaraCrud\Models;

use App;
use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Traits\Helper;

abstract class NodeModelConfigurationManager implements NodeModelConfigurationInterface
{

    use Helper;

    protected $model;
    protected $class;
    public $admin;
    protected $alias;
    protected $app;
    protected $title;
    protected $url;
    public $objRoute;
    private static $objModel;

    protected $buttonDelete = true;
    protected $buttonEdit = true;
    protected $buttonAdd = true;
    protected $buttonApply = true;
    protected $buttonCopy = true;
    protected $buttonGroupDelete = true;

    protected $fieldShow = [];
    protected $fieldName = [];
    public $textLimit = [];
    protected $fieldOrderBy = [1, 'asc'];
    protected $showEntries = 10;
    protected $setWhere = [];
    protected $columnColorWhere = [];
    protected $newAction = []; //кнопки Action
    protected $setTypeField = [];
    protected $formShowId;

    //property field
    protected $addFieldClass = [];
    protected $addFieldTitle = [];
    protected $addFieldPlaceholder = [];
    protected $setValue = [];
    protected $tab = [];
    protected $fieldOption = []; // Опции для передачи в классы полей
    protected $objClassSelectAjax = []; // хранит обьект класса переданного для выборки для select2

    protected $enableEditor = [];
    protected $setFileUploadSeting = []; //сохраняем масив с настройками для полей file
    protected $dashboard;

    protected $modelTableSelect; //обьект модели подгрузки для select2
    public $OtherTable; //таблица для записи multiple
    protected $modelRelation; //хранит обьект класса Relationships

    protected $tooltip; //Подсказки tooltip.js
    protected $validation = null;
    protected $validation_messages = [];

    protected $fieldOneToMany; //хранит масив полей с данными для отношения один ко многим
    protected $primary_key_relation; //название поля id таблицы один ко многим
    public static $navigation_title;
    protected $closure;

    protected $closureRowsRender;
    protected $closureShowFormCollback;

    protected $view = null; //для кастомного вида
    protected $alertDelete;
    protected $showChildRows; //обратный вызов для child rows
    protected $ajaxBeforeLoadSelect; //хук перед загрузкой данных в select
    protected $arrField; //определяем выбор selected по умолчанию
    protected $setModelCollback = null; //функция обратного вызова для получения модели выборки таблицы
    protected $showChildRowsClass;
    protected $addViewsCustomTop; //хук вывод произвольного вида над формой или таблицей

    protected $setClassForm = null;

    protected $_afterUpdate;
    protected $fieldAttribute;
    protected $fieldOrderByDisable;
    protected $enableDragAndDrop;
    protected $setOrderFixed;
    protected $fieldDisable;
    protected $saveRedirect; //редирект на казаний урл при сохранении формы
    protected $disablePaginate = true; //отключение пагинации

    protected $newColumn = [];

    protected $setBeforeModelFormCollback = null; //можно изменить данные модели перед самим выводом формы

    protected $joinTableObj; //храним обьект класса JoinTables присоединение таблиц
    protected $stateSave = true; //сохранение пагинации
    protected $searchDisable = true; //отключение поиска включен по дефолту
    protected $searshIndividualObject;//колонки для индивидуального поиска

    /**
     * NodeModelConfigurationManager constructor.
     * @param Application $app
     * @param null $model
     */
    public function __construct(Application $app, $model = null)
    {

        $this->app = $app;
        $this->model = $model;

        $this->joinTableObj = new JoinTables();
    }

    /**
     * @param $query
     */
    public function scopeTest($query)
    {
        $query->where('id', '=', 1);
    }

    /**
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getModelObj()
    {
        if (empty(self::$objModel)) {
            self::$objModel = new $this->model;
        }
        return self::$objModel;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * @return array
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return bool
     */
    public function getButtonDelete(): bool
    {
        return $this->buttonDelete;
    }

    /**
     * @return bool
     */
    public function getButtonApply(): bool
    {
        return $this->buttonApply;
    }

    /**
     * @return bool
     */
    public function getButtonEdit(): bool
    {
        return $this->buttonEdit;
    }

    /**
     * @return array
     */
    public function getFieldShow(): array
    {
        return $this->fieldShow;
    }


    /**
     * @return array
     *
     */
    public function getTextLimit($object)
    {
        foreach ($this->textLimit as $field => $limit) {
            $object->{$field} = str_limit($object->{$field}, $limit, $end = '...');
        }
        return $object;
    }

    /**
     * @return array
     */
    public function getFieldOrderBy(): array
    {
        return $this->fieldOrderBy;
    }

    /**
     * @return mixed
     */
    public function getShowEntries(): int
    {
        return $this->showEntries;
    }


    /**
     * @return array
     * todo поля доступные для выборки
     */
    public function nameColumns(): array
    {

        //поля исходной таблицы берутся из схемы данных таблицы
        $tableColumns = $this->admin->TableColumns;

        //проверяем есть ли присоединенная таблица если есть берем поля после AS
        if ($this->joinTableObj()->getJoinTable() != null) {
            $tableColumns = $this->joinTableObj()->getAsName();
        }

        $field = array_merge($tableColumns, $this->newColumn);


        $field_name = $this->getFieldName();
        $field_display = $this->getFieldShow();

        //проверяем определен ли масив полей которые должны отображатся и осуществляем схождение масивов всех полей и обьявленных
        if (!empty($field_display)) {
            $field = array_intersect($field_display, $field);
        }

        $data = [];
        foreach ($field as $fields) {

            if (isset($field_name[$fields])) {
                $data[$fields] = $field_name[$fields];
            } else {
                $data[$fields] = $fields;
            }

        }

        return $data;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function getWhere($query)
    {
        if (!empty($this->setWhere)) {
            $query = $query->where($this->setWhere[0], $this->setWhere[1], $this->setWhere[2]);
        }

        return $query;
    }


    /**
     * @param $obj
     * @return mixed
     * todo хук для строк таблицы
     */
    public function SetTableRowsRenderCollback($obj)
    {
        return $this->closureRowsRender !== null ? $this->closureRowsRender->call($this, $obj) : $obj;
    }

    /**
     * @param $obj
     * @return mixed
     * todo хук перед открытием формы редактирования
     */
    public function SetBeforeShowFormCollback($obj, $view, $curentModel)
    {
        if ($this->closureShowFormCollback !== null) {
            $return = $this->closureShowFormCollback->call($this, $obj, $view, $curentModel);
            return $return ? $return : $view;
        } else {
            return $view;
        }

    }


    /**
     * @param $obj
     * @param $view
     * @return bool|mixed
     */
    public function SetShowChildRows()
    {
        return $this->showChildRowsClass;
    }


    /**
     * @return bool|mixed
     */
    public function getShowChildRows()
    {
        if (!empty($this->showChildRowsClass)) {
            return true;
        }

        return false;
    }


    /**
     * @return array|bool
     * todo метод готовид масив для выделения цветами строк в таблице
     */
    public function getColumnColorWhere()
    {
        $data = false;
        if (!empty($this->columnColorWhere)) {
            foreach ($this->columnColorWhere as $item) {
                $data[] = [
                    'field' => $item[0],
                    'operand' => $item[1],
                    'value' => $item[2],
                    'color' => $item[3],
                ];
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getNewAction()
    {

        return $this->newAction;
    }


    /**
     * @param $closure
     * @param $obj
     * todo запускает функцию обратного вызова новых кнопок Action
     */
    public function newActionCollback(\Closure $closure, $obj)
    {
        $closure !== null ? $closure->call($this, $obj) : $obj;
    }


    /**
     * @param $nameField // имя поля
     * @param $valueModel //данные из базы
     * @return array|mixed|null
     */
    public function getValue($nameField, $valueModel)
    {

        if (!empty($this->setTypeField[$nameField])) {

            if (is_array($this->setTypeField[$nameField])) {

                //если васив определяем тип поля
                switch ($this->setTypeField[$nameField][0]) {
                    case 'select':

                        $this->setValue[$nameField] = $this->setTypeField[$nameField][1];

                        //проверяем если передан класс то ничего не возвращаем
                        if (empty($this->objClassSelectAjax[$nameField])) {  // без аякса

                            if (!empty($this->setTypeField[$nameField][2]) and $this->setTypeField[$nameField][2] === 'multiple') {

                                $curentValue = is_array(json_decode($valueModel)) ? array_flip(json_decode($valueModel)) : null;

                                return ['curentValue' => $curentValue, 'selectValue' => $this->setTypeField[$nameField][1]];
                            } else {
//
                                //предопределенный выбор
                                $valueModel = !empty($this->getDefaultSelected($nameField)) ? $this->getDefaultSelected($nameField) : $valueModel;
                                return ['curentValue' => $valueModel, 'selectValue' => $this->setTypeField[$nameField][1]];
                            }

                        } else { //с аяксом

                            //данные для определения текущего значения выбраного из списка
                            //получам текст для поля select
                            $arr = ['ajaxCurentValue' => null, 'ajaxCurrentText' => null];

                            //проверяем если 'multiple' то будем брать данные из сторонней таблицы
                            if (empty($this->setTypeField[$nameField][2]) or $this->setTypeField[$nameField][2] !== 'multiple') {

                                if (!empty($this->objClassSelectAjax[$nameField]['model']->find($valueModel)->{$this->objClassSelectAjax[$nameField]['select']})) {

                                    $ajaxCurrentText = $this->objClassSelectAjax[$nameField]['model']->find($valueModel)->{$this->objClassSelectAjax[$nameField]['select']};

                                    $arr['ajaxCurentValue'] = $valueModel;
                                    $arr['ajaxCurrentText'] = $ajaxCurrentText;
                                }

                            } else {

                                $arr['ajaxCurentValueMultiple'] = $this->getOtherTable($this->objClassSelectAjax[$nameField]);

                            }

                            return $arr;
                        }

                        break;

                    case 'file':
                        break;

                    case 'checkbox':
                        return ['curentValue' => $valueModel, 'selectValue' => $this->setTypeField[$nameField][1]];
                        break;

                    case 'radio':
                        if (!empty($this->setValue[$nameField])) {
                            $valueModel = $this->setValue[$nameField];
                        }
                        return ['curentValue' => $valueModel, 'selectValue' => $this->setTypeField[$nameField][1]];
                        break;
                    default:

                        //если подключено отношение один ко многим
                        if ($this->getOneToMany($nameField) !== false) {

                            $arr['selectValue'] = $this->getOtherTableOneToMany($this->getOneToMany($nameField));
                            $arr['primary_key_relation'] = $this->primary_key_relation;
                            return $arr;

                        }

                        if (empty($valueModel)) {
                            $this->setValue[$nameField] = $this->setTypeField[$nameField][1];
                        } else {
                            return $valueModel;
                        }
                        return $this->setValue[$nameField];

                }
            }

        }

        if (!empty($this->setValue[$nameField])) {
            return $this->setValue[$nameField];
        }

        if (!empty($valueModel)) {
            return $valueModel;
        }

        return null;
    }

    /**
     * @param array $arrFieldType
     * todo устанавливаем значения полей по умолчанию
     */
    public function setValue(array $arrFieldType)
    {
        $this->setValue = $arrFieldType;
    }

    /**
     * @param $nameField
     * @param $fieldSetindArr
     */
    public function setFileUploadSeting($nameField, $fieldSetindArr)
    {
        $this->setFileUploadSeting[$nameField] = [
            'path' => (!empty($fieldSetindArr[1])) ? $fieldSetindArr[1] : 'uploads',
            'status' => (!empty($fieldSetindArr[2]) and $fieldSetindArr[2] === 'multiple') ? 'multiple' : null //если пустой то предполагается что только одна картинка если multiple то множественные
        ];
    }

    /**
     * @param string $field
     * @return bool|mixed
     * todo получаем вид поля нвпример select по ключу по умолчанию input
     */
    public function getTypeField(string $field)
    {
        if (!empty($this->setTypeField[$field])) {

            if (is_array($this->setTypeField[$field])) {
                return $this->setTypeField[$field][0];
            }

            return $this->setTypeField[$field];
        }
        return null;
    }

    /**
     * @param string $field
     * @return mixed|null
     * todo получаем масив конфигурации поля
     */
    public function getTypeFieldAllArr(string $field)
    {
        if (!empty($this->setTypeField[$field])) {
            return $this->setTypeField[$field];
        }
        return null;
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    public function getFieldClass(string $field)
    {
        if (!empty($this->addFieldClass[$field])) {
            return $this->addFieldClass[$field];
        }
        return null;
    }


    /**
     * @param string $field
     * @return mixed
     */
    public function getFieldOption(string $field)
    {
        if (!empty($this->fieldOption[$field])) {
            return $this->fieldOption[$field];
        }
        return null;
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    public function getFieldTitle(string $field)
    {
        if (!empty($this->addFieldTitle[$field])) {
            return $this->addFieldTitle[$field];
        }
        return null;
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    public function getFieldPlaceholder(string $field)
    {
        if (!empty($this->addFieldPlaceholder[$field])) {
            return $this->addFieldPlaceholder[$field];
        }
        return null;
    }


    /**
     * @param string $field
     * @return bool
     */
    public function getEnableEditor(string $field)
    {
        if (in_array($field, $this->enableEditor)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     * todo вкладки
     */
    public function getTab()
    {
        return $this->tab;
    }


    /**
     * @param null $field
     * @return array|mixed
     * todo настройки для поля file
     */
    public function getFileUploadSeting($field = null)
    {
        if ($field !== null and !empty($this->setFileUploadSeting[$field])) {
            return $this->setFileUploadSeting[$field];
        };
        return false;
    }

    /**
     * @return array
     */
    public function getFileUploadSetingAll()
    {
        return $this->setFileUploadSeting;
    }

    /**
     * @return mixed
     * todo метод определяет тип вывода если обьевлен форма редактирования виводится сразу может принимать id строки в таблице
     */
    public function getFormShow()
    {
        return $this->formShowId;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getObjClassSelectAjax($field)
    {
        return $this->objClassSelectAjax[$field];
    }

    /**
     * @param $data
     */
    public function setDashboard($data)
    {
        $this->dashboard = $data;
    }

    /**
     * @return mixed
     */
    public function getDashboard()
    {
        return $this->dashboard;
    }

    /**
     * @return bool
     */
    public function getButtonAdd(): bool
    {
        return $this->buttonAdd;
    }

    /**
     * @return bool
     */
    public function getButtonCopy(): bool
    {
        return $this->buttonCopy;
    }

    /**
     * @return bool
     */
    public function getButtonGroupDelete(): bool
    {
        return $this->buttonGroupDelete;
    }


    /**
     * @param $nameField
     * @return mixed
     */
    public function getCurentValueMultiple($nameField, $model = null)
    {

        if (!empty($this->OtherTable[$nameField]) and $model !== null) {

            $this->modelRelation = new Relationships($model, $this->OtherTable[$nameField]['model'],
                $this->OtherTable[$nameField]['ralation_table'],
                $this->OtherTable[$nameField]['foreign_key'],
                $this->OtherTable[$nameField]['local_key']);

            return $this->modelRelation;
        }

        return false;
    }


    /**
     * @param $objClassSelectAjax
     * @return array|null
     * todo метод формирует масив для вывода выбраных элементов при редктировании
     */
    public function getOtherTable($objClassSelectAjax)
    {

        $data = [];
        if ($this->modelRelation !== null) {
            foreach ($this->modelRelation->ManyToMany()->get() as $item) {
                $data[] = ['id' => $item[$objClassSelectAjax['id']], 'text' => strip_tags($item[$objClassSelectAjax['select']])];
            }
            return $data;
        }

        return null;
    }


    /**
     * @param $objClass
     * @return null
     * todo получает данные из связаной таблицы один ко многим
     */
    public function getOtherTableOneToMany($objClass)
    {
        $select = null;
        if ($objClass['list_fields'] !== null) {
            //получаем названия полей таблицы для выборки
            $this->primary_key_relation = App::make($objClass['model'])->getKeyName();
            $select = array_keys($objClass['list_fields']);
            array_unshift($select, $this->primary_key_relation);
        }

        if ($this->modelRelation !== null) {
            return $this->modelRelation->OneToMany()->get($select)->toArray();
        }
        return [];
    }

    /**
     * @param $fieldName
     * @return array
     *  получаем масив для поля отношения к таблице данные таблицы и полей
     */
    public function getOtherTableArray($fieldName): array
    {
        return $this->OtherTable[$fieldName];
    }


    /**
     * @param $fieldName
     * @return bool
     */
    public function getTooltip($fieldName)
    {
        if (empty($this->tooltip[$fieldName])) {
            return false;
        }

        if (is_array($this->tooltip[$fieldName])) {
            $this->addFieldTitle[$fieldName] = $this->tooltip[$fieldName][0];
            $this->tooltip[$fieldName] = isset($this->tooltip[$fieldName][1]) ? $this->tooltip[$fieldName][1] : 'top';
        } else {
            $this->addFieldTitle[$fieldName] = $this->tooltip[$fieldName];
            $this->tooltip[$fieldName] = 'top';
        }

        return $this->tooltip[$fieldName];
    }


    /**
     * @return null
     */
    public function getValidationRule()
    {
        return $this->validation;
    }


    /**
     * @return array
     */
    public function getValidationMessage()
    {
        return $this->validation_messages;
    }

    /**
     * @param $fieldName
     * @return bool|int
     *
     */
    public function getRequired($fieldName)
    {
        if (!empty($this->validation[$fieldName])) {
            return strpos($this->validation[$fieldName], 'required');
        }

        return false;
    }

    /**
     * @return mixed
     * todo проверяем есть ли отношение на этом поле если есть то возвражаем в противном случае false
     */
    public function getOneToMany($fieldName)
    {
        if (!empty($this->fieldOneToMany[$fieldName])) {
            return $this->fieldOneToMany[$fieldName];
        }

        return false;
    }

    /**
     * @param $nameField
     * @param null $model
     * @return bool|Relationships
     */
    public function getCurentValueOneToMany($nameField, $model = null)
    {
        if ($this->getOneToMany($nameField) and $model !== null) {

            $relate = $this->getOneToMany($nameField);

            $this->modelRelation = new Relationships($model, $relate['model'],
                null,
                $relate['foreign_key'],
                $relate['local_key']);
            return $this->modelRelation;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getBolleanCheckedColumn()
    {
        if ($this->getButtonGroupDelete() === true OR $this->getButtonCopy() === true) {
            return true;
        } else {
            return "false";
        }
    }


    /**
     * @return mixed|null
     */
    public function getRenderCustom()
    {
        return $this->view;
    }


    /**
     * @param $param
     * @return mixed
     */
    public function getAlertDelete($param)
    {
        return $this->alertDelete[$param];
    }

    /**
     * @param $model
     * @param $request
     * @return mixed
     */
    public function setAjaxBeforeLoadSelect($model, $request)
    {
        $data = null;

        if (!empty($this->ajaxBeforeLoadSelect)) {
            $request->get_param = json_decode(htmlspecialchars_decode($request->get_param));
            $data = $this->ajaxBeforeLoadSelect->call($this, $model, $request);
        }

        if ($data !== null) {
            return $data;
        }

        return $model;
    }


    /**
     * @param string $field
     * @return mixed|null
     */
    public function getDefaultSelected(string $field)
    {
        if (!empty($this->arrField[$field])) {
            return $this->arrField[$field];
        }
        return null;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function getModelCollback($model)
    {
        if ($this->setModelCollback !== null) {
            $query = $this->setModelCollback->call($this, $model);
            return $query;
        } else {
            return $model;
        }
    }


    /**
     * @param $model
     * @return bool|mixed
     */
    public function setViewsCustomTop($model)
    {
        if (!empty($this->addViewsCustomTop)) {
            return $this->addViewsCustomTop->call($this, $model);
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getClassForm()
    {
        return $this->setClassForm;
    }

    /**
     * @param $model
     */
    public function setAfterUpdate($model)
    {
        if ($this->_afterUpdate !== null) {
            $this->_afterUpdate->call($this, $model);
        }
    }

    /**
     * @param $field
     * @return null
     */
    public function getAttribute($field)
    {
        if (!empty($this->fieldAttribute[$field])) {
            return $this->fieldAttribute[$field];
        }
        return null;
    }

    /**
     * @param $nameField
     * @return bool
     */
    public function getFieldOrderByDisable($nameField)
    {

        if (!empty($this->fieldOrderByDisable) and in_array($nameField, $this->fieldOrderByDisable)) {
            return false;
        }

        return true;
    }


    /**
     * @return mixed
     */
    public function getEnableDragAndDrop()
    {
        if (!empty($this->enableDragAndDrop)) {
            return $this->enableDragAndDrop;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getOrderFixed()
    {
        if (!empty($this->setOrderFixed)) {
            return $this->setOrderFixed;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getFieldDisable()
    {
        return $this->fieldDisable;
    }

    /**
     * @return mixed
     */
    public function getSaveRedirect()
    {
        return $this->saveRedirect;
    }


    /**
     * @return bool
     */
    public function getDisablePaginate()
    {
        return $this->disablePaginate;
    }


    /**
     * @param bool $column
     * @return array|bool|mixed
     */
    public function getNewColumn($column = false)
    {
        if ($column !== false) {
            return (in_array($column, $this->newColumn)) ? $column : false;
        }
        return $this->newColumn;
    }

    /**
     * @param $obj
     * @return mixed
     */
    public function getBeforeModelFormCollback($obj)
    {
        return $this->setBeforeModelFormCollback !== null ? $this->setBeforeModelFormCollback->call($this, $obj) : $obj;
    }


    /**
     * @return mixed
     */
    public function joinTableObj()
    {
        return $this->joinTableObj;
    }

    /**
     * @return bool|mixed
     */
    public function getStateSave()
    {
        return $this->stateSave;
    }

    /**
     * @return bool|mixed
     */
    public function getSearchDisable()
    {
        return $this->searchDisable;
    }

    /**
     * @return mixed
     */
    public function getSearshIndividualObject()
    {
        return $this->searshIndividualObject;
    }
}