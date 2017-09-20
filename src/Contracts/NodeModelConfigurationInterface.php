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
    public function getTitleEdit ();
    public function getModelObj (); //обект класса модели

    public function scopeTest ($query);


    public function fieldName(array $field);



}