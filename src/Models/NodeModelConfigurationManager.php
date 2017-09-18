<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 30.08.2017
 * Time: 22:43
 */

namespace Trafik8787\LaraCrud\Models;

use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;

abstract class NodeModelConfigurationManager implements NodeModelConfigurationInterface
{


    protected $model;
    protected $class;
    protected $alias;
    protected $app;
    protected $title;
    protected $titleEdit;
    public $url;
    public $objRoute;
    private static $objModel;
   // public $objDataTable;

    public function __construct (Application $app, $model) {

        $this->app= $app;
        $this->model = $model;

    }

    public function scopeTest ($query)
    {
        $query->where('id', '=', 1);
    }

    public function getModel () {
        return $this->model;
    }

    public function getModelObj()
    {
        if (empty(self::$objModel)) {
            self::$objModel = new $this->model;
        }
        return self::$objModel;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getTitle ()
    {
        return $this->title;
    }

    public function getTitleEdit ()
    {
        return $this->titleEdit;
    }

}