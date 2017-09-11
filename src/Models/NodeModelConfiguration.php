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

    public $tmp;

    public function setTitle ($title)
    {
        $this->title = $title;
    }


    public function url ($url)
    {
        $this->url = $url;
    }

    public function setTitleEdit ($title)
    {
        $this->titleEdit = $title;
    }


}