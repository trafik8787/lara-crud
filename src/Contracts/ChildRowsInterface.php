<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 31.05.18
 * Time: 14:17
 */

namespace Trafik8787\LaraCrud\Contracts;


interface ChildRowsInterface
{
    /**
     * @param null $view
     * @return mixed
     */
    public function view($view = null);

    /**
     * @param null $model
     * @return mixed
     */
    public function model($model = null);

    /**
     * @param $objConfig
     * @return mixed
     */
    public function render($objConfig);

    /**
     * @param array $arrayField
     * @return mixed
     */
    public function nameField(array $arrayField = []);

}