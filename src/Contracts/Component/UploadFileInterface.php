<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 10.10.2017
 * Time: 20:51
 */

namespace Trafik8787\LaraCrud\Contracts\Component;


interface UploadFileInterface
{
    /**
     * @return mixed
     */
    public function setUploadFile();

    /**
     * @param $obj
     * @return mixed
     */
    public function objConfig($obj);

    /**
     * @param $nameField
     * @param $file
     * @return mixed
     */
    public function saveFile($nameField, $file);
}