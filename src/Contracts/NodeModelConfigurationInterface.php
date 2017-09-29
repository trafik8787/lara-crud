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
    public function getAlias ();

    /**
     * @return mixed
     */
    public function getClass();

    /**
     * @return mixed
     */
    public function getModel ();

    /**
     * @return mixed
     */
    public function getTitle ();


    /**
     * @return mixed
     */
    public function getModelObj (); //обект класса модели

    /**
     * @param $query
     * @return mixed
     */
    public function scopeTest ($query);


    /**
     * @param array $field
     * @return mixed
     */
    public function fieldName(array $field);

    /**
     * @return mixed
     */
    public function getButtonDelete (): bool;

    /**
     * @return mixed
     */
    public function getButtonEdit(): bool;

    /**
     * @return mixed
     */
    public function getFieldShow(): array ;

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
    public function getShowEntries():int ;

    /**
     * @return array
     * todo измененные названия полей сортировка
     */
    public function nameColumns():array ;

    /**
     * @param $obj
     * @return mixed
     * todo передача в функцию обратного вызова отрисовка каждой строки в таблице вызывается функция
     */
    public function SetTableRowsRenderCollback ($obj);


    /**
     * @return mixed
     */
    public function getColumnColorWhere ();

    /**
     * @return mixed
     */
    public function getNewAction ();


    /**
     * @param $closure
     * @param $obj
     * @return mixed
     */
    public function newActionCollback (Closure $closure, $obj);

    /**
     * @param string $field
     * @return mixed
     * todo получаем вид поля нвпример select по ключу
     */
    public function getTypeField (string $field);


    /**
     * @param string $field
     * @return mixed
     * todo клас для поля
     */
    public function getFieldClass (string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function getFieldTitle (string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function getFieldPlaceholder (string $field);



}