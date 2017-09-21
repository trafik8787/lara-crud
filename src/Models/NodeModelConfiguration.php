<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 28.08.2017
 * Time: 20:26
 */

namespace Trafik8787\LaraCrud\Models;

use Closure;

class NodeModelConfiguration extends NodeModelConfigurationManager
{


    /**
     * @param $title
     */
    public function setTitle ($title)
    {
        $this->title = $title;
    }


    /**
     * @param $url
     */
    public function url ($url)
    {
        $this->url = $url;
    }

    /**
     * @param $title
     */
    public function setTitleEdit ($title)
    {
        $this->titleEdit = $title;
    }

    /**
     * @param array $field
     */
    public function fieldName(array $field)
    {
        $this->fieldName = $field;
    }
    /**
     * @param bool $value
     */
    public function buttonDelete (bool $value = true)
    {
        $this->buttonDelete = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonEdit (bool $value = true){
        $this->buttonEdit = $value;
    }

}