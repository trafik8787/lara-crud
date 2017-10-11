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
    public function setUploadFile();
    public function objConfig($obj);
    public function saveFile($nameField, $file);
}