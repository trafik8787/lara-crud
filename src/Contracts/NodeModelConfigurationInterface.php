<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:20
 */

namespace Trafik8787\LaraCrud\Contracts;

use Closure;

interface NodeModelConfigurationInterface
{
    /**
     * @return mixed
     */
    public function getAlias();

    /**
     * @return mixed
     */
    public function getClass();

    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @return mixed
     */
    public function getTitle();


    /**
     * @return mixed
     */
    public function getModelObj(); //обект класса модели

    /**
     * @param $query
     * @return mixed
     */
    public function scopeTest($query);


    /**
     * @param array $field
     * @return mixed
     */
    public function fieldName(array $field);

    /**
     * @return mixed
     */
    public function getButtonDelete(): bool;

    /**
     * @return mixed
     */
    public function getButtonEdit(): bool;

    /**
     * @return boll
     */
    public function getButtonApply(): bool;

    /**
     * @return bool
     */
    public function getButtonAdd(): bool;

    /**
     * @return bool
     */
    public function getButtonCopy(): bool;

    /**
     * @return bool
     */
    public function getButtonGroupDelete(): bool;

    /**
     * @return mixed
     */
    public function getFieldShow(): array;

    /**
     * @return array
     *
     */
    public function getTextLimit($object);

    /**
     * @return array
     */
    public function getFieldOrderBy(): array;

    /**
     * @return array
     * todo возвращяем масив для выборки
     */
    public function getWhere($query);


    /**
     * @return int
     */
    public function getShowEntries(): int;

    /**
     * @return array
     * todo измененные названия полей сортировка
     */
    public function nameColumns(): array;

    /**
     * @param $obj
     * @return mixed
     * todo передача в функцию обратного вызова отрисовка каждой строки в таблице вызывается функция
     */
    public function SetTableRowsRenderCollback($obj);


    /**
     * @return mixed
     */
    public function getColumnColorWhere();

    /**
     * @return mixed
     */
    public function getNewAction();


    /**
     * @param $closure
     * @param $obj
     * @return mixed
     */
    public function newActionCollback(Closure $closure, $obj);

    /**
     * @param string $field
     * @return mixed
     * todo получаем вид поля нвпример select по ключу
     */
    public function getTypeField(string $field);


    /**
     * @param string $field
     * @return mixed
     * todo клас для поля
     */
    public function getFieldClass(string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function getFieldTitle(string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function getFieldPlaceholder(string $field);


    /**
     * @param array $arrayValue
     * @return mixed
     */
    public function getValue($nameField, $valueModel);


    /**
     * @param string $field
     * @return mixed
     */
    public function getEnableEditor(string $field);


    /**
     * @return mixed
     */
    public function getTab();


    /**
     * @return mixed
     */
    public function getFileUploadSeting($field = null);

    /**
     * @param null $field
     * @return mixed
     * todo метод определяет тип вывода если обьевлен форма редактирования виводится сразу может принимать id строки в таблице
     */
    public function getFormShow();

    /**
     * @return mixed
     */
    public function getFileUploadSetingAll();

    /**
     * @param array $arrFieldType
     * @return mixed
     */
    public function setValue(array $arrFieldType);

    /**
     * @param $field
     * @param $path
     * @param null $status
     * @return mixed
     */
    public function setFileUploadSeting($nameField, $fieldSetindArr);

    /**
     * @param string $field
     * @return mixed
     */
    public function getTypeFieldAllArr(string $field);

    /**
     * @return mixed
     * todo дополнительные опции для полей
     */
    public function getFieldOption(string $field);

    /**
     * @return mixed
     * todo метод получаем обьект класса переданного для SELECT2
     */
    public function getObjClassSelectAjax($field);

    /**
     * @return mixed
     */
    public function setDashboard($data);

    /**
     * @return mixed
     */
    public function getDashboard();

    /**
     * @return mixed
     * todo метод хранит модель и поля таблицы для meny to meny
     */
    public function getCurentValueMultiple($nameField, $model);

    /**
     * @param $nameField
     * @return mixed
     * получаем данные таблицы отношения
     */
    public function getOtherTable($objClassSelectAjax);


    /**
     * @param $fieldName
     * @return array
     * получаем масив для поля отношения к таблице данные таблицы и полей
     */
    public function getOtherTableArray($fieldName): array;

    /**
     * @param $fieldName
     * @return mixed
     */
    public function getTooltip($fieldName);


    /**
     * @return mixed
     */
    public function getValidationRule();


    /**
     * @return mixed
     */
    public function getValidationMessage();

    /**
     * @return mixed
     */
    public function getOneToMany($fieldName);


    /**
     * @param $nameField
     * @param $model
     * @return mixed
     */
    public function getCurentValueOneToMany($nameField, $model);

    /**
     * @param $objClass
     * @return mixed
     * todo получает данные из связаной таблицы один ко многим
     */
    public function getOtherTableOneToMany($objClass);


    /**
     * @return bool
     * todo определяем будет ли отображен столбец checkbox
     */
    public function getBolleanCheckedColumn(): bool;


    /**
     * @param $fieldName
     * @return mixed
     */
    public function getRequired($fieldName);


    /**
     * @return mixed
     */
    public function getRenderCustom();


    /**
     * @param $param
     * @return mixed
     */
    public function getAlertDelete($param);


    /**
     * @param $obj
     * @param $view
     * @return mixed
     */
    public function SetBeforeShowFormCollback($obj, $view);


    /**
     * @param $obj
     * @param $view
     * @return mixed
     */
    public function SetShowChildRows();

    /**
     * @return mixed
     */
    public function getShowChildRows();

    /**
     * @param $model
     * @param $request
     * @return mixed
     */
    public function setAjaxBeforeLoadSelect($model, $request);

    /**
     * @param string $field
     * @return mixed
     */
    public function getDefaultSelected(string $field);


    /**
     * @param $model
     * @return mixed
     */
    public function getModelCollback($model);

    /**
     * @param $model
     * @return mixed
     */
    public function setViewsCustomTop($model);
}