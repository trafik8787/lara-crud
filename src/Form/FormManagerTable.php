<?php
namespace Trafik8787\LaraCrud\Form;
use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;

/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:07
 */

abstract class FormManagerTable implements FormManagerInterface
{
    protected $objConfig;

    /**
     * @return mixed
     */
    public function getObjConfig()
    {
        return $this->objConfig;
    }

}