<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:20
 */

namespace Trafik8787\LaraCrud\Contracts;




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
     * @return int
     */
    public function getShowEntries():int ;

}