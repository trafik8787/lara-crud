<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:09
 */

namespace Trafik8787\LaraCrud\Contracts;


interface FormManagerInterface
{
    public function getType ($field);
    public function getNameColumns ():array ;
    public function getTypeColumns ():array ;
    public function getArrayField ();

}