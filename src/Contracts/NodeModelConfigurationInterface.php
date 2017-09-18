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


    public function getAlias ();
    public function getClass();
    public function getModel ();
    public function getTitle ();
    public function getModelObj (); //обект класса модели

    public function scopeTest ($query);


}