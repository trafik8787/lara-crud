<?php
namespace  Trafik8787\LaraCrud\Traits;
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 20.11.2017
 * Time: 15:01
 */

trait Helper
{
    public function isJSON($data){
        $result = json_decode($data);
        return ( json_last_error() === JSON_ERROR_NONE) ;
    }
}