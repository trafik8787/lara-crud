<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 30.08.2017
 * Time: 22:43
 */

namespace Trafik8787\LaraCrud\Models;

use Illuminate\Contracts\Foundation\Application;
use Mockery\Matcher\Closure;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;

abstract class NodeModelConfigurationManager implements NodeModelConfigurationInterface
{
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

    protected $disableEditor = [];
    protected $setFileUploadSeting = []; //сохраняем масив с настройками для полей file

    protected $closure;
    /**
     * NodeModelConfigurationManager constructor.
     * @param Application $app
     * @param null $model
     */
    public function __construct (Application $app, $model = null) {

        $this->app= $app;
        $this->model = $model;
    }

    /**
     * @param $query
     */
    public function scopeTest ($query)
    {
        $query->where('id', '=', 1);
    }

    /**
     * @return null
     */
    public function getModel () {
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
    public function getTitle ()
    {
        return $this->title;
    }


    /**
     * @return array
     */
    public function getFieldName() {
        return $this->fieldName;
    }

    /**
     * @return bool
     */
    public function getButtonDelete (): bool
    {
        return $this->buttonDelete;
    }

    /**
     * @return bool
     */
    public function getButtonEdit (): bool
    {
        return $this->buttonEdit;
    }

    /**
     * @return array
     */
    public function getFieldShow(): array {
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
    public function getShowEntries():int
    {
        return $this->showEntries;
    }


    /**
     * @return array
     * todo поля доступные для выборки
     */
    public function nameColumns ():array
    {

        $field = $this->admin->TableColumns;
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
            $query->where($this->setWhere[0], $this->setWhere[1], $this->setWhere[2]);
        }

        return $query;
    }


    /**
     * @param $obj
     * @return mixed
     * todo хук для строк таблицы
     */
    public function SetTableRowsRenderCollback ($obj)
    {
        return $this->closure !== null ? $this->closure->call($this, $obj) : $obj;
    }


    /**
     * @return array|bool
     * todo метод готовид масив для віделения цветами строк в таблице
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
    public function getNewAction() {

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
     * @param $nameField
     * @param $valueModel
     * @return array|mixed|null
     */
    public function getValue ($nameField, $valueModel)
    {
        if (!empty($this->setTypeField[$nameField]) and $this->setTypeField[$nameField] === 'select') {
            return ['curentValue' => $valueModel, 'selectValue' => $this->setValue[$nameField]];
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
     * @param string $field
     * @return bool|mixed
     * todo получаем вид поля нвпример select по ключу по умолчанию input
     */
    public function getTypeField(string $field)
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
    public function getDisableEditor(string $field)
    {
        if (!empty($this->disableEditor[$field])) {
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
    public function getFileUploadSetingAll() {
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
}