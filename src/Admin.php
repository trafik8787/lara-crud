<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:41
 */

namespace Trafik8787\LaraCrud;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Models\ModelCollection;



class Admin implements AdminInterface
{

    public $app;
    public $nodes;
    public $defaultUrlArr; //url формируем из названия модели по умолчанию url => Class
    public $nameModelArr; // url => Model
    public $models;
    public $route;
    public $objConfig;

    public $TableColumns = [];
    public $TableTypeColumns = [];

    private $request; //получает обьект Request из AdminController

    public function __construct ($node, Application $app) {
        $this->app = $app;
        $this->models = new ModelCollection();


        $this->initNode($node);
    }

    /**
     * @param array $nodes
     */
    public function initNode (array $nodes) {

        $this->nodes = $nodes;

        foreach ($this->nodes as  $model => $nodeClass) {

            $url = $this->setUrlDefaultModel($model);
            $this->defaultUrlArr[$url] = $nodeClass;
            $this->nameModelArr[$url] = $model;

        }

        $this->app->call([$this, 'setRoute']);


    }


    /**
     * @param string $strModelName
     * @return string
     * преобразуем название модели в URL
     */
    public function setUrlDefaultModel (string $strModelName)
    {
        return snake_case(class_basename($strModelName));
    }

    /**
     * @param $class
     * @param NodeModelConfigurationInterface $modelConf
     * @return $this
     */
    public function setModel($class, NodeModelConfigurationInterface $modelConf)
    {
        $this->models->put($class, $modelConf);
        return $this;
    }

    /**
     * @return ModelCollection
     */
    public function getModels()
    {
        return $this->models;
    }


    /**
     *
     */
    public function getObjConfig ()
    {

        if (!empty($this->defaultUrlArr[$this->route->parameters['adminModel']])) {

            $obj = $this->defaultUrlArr[$this->route->parameters['adminModel']];
            $model = $this->nameModelArr[$this->route->parameters['adminModel']];

            $this->initNodeClass(new $obj($this->app, $model)); //создает обьект $this->objConfig класса NodeModelConfigurationInterface

        }

    }


    /**
     * @param NodeModelConfigurationInterface $modelConf
     */
    public function initNodeClass(NodeModelConfigurationInterface $modelConf)
    {


        //$this->setModel($modelConf->getModel(), $modelConf);

        if ($this->route->action['as'] === 'model.showTable') {

            if (method_exists($modelConf, 'showDisplay')) {
                $modelConf->showDisplay();
            }

        } elseif ($this->route->action['as'] === 'model.ajax.dispaly.table') {

            if (method_exists($modelConf, 'showDisplay')) {
                $modelConf->showDisplay();
            }

        } elseif ($this->route->action['as'] === 'model.edit') {
            if (method_exists($modelConf, 'showEditDisplay')) {
                $modelConf->showEditDisplay();
            }
        } elseif ($this->route->action['as'] === 'model.create') {
            if (method_exists($modelConf, 'showInsertDisplay')) {
                $modelConf->showInsertDisplay();
            }
        } elseif ($this->route->action['as'] === 'model.delete') {
            if (method_exists($modelConf, 'showDelete')) {
                $modelConf->showDelete();
            }
        }

        $this->setModel($modelConf->getModel(), $modelConf);

        $this->objConfig = $modelConf;
        $this->app->call([$this, 'registerDatatable']);
    }


    /**
     * @param NodeModelConfigurationInterface $nodeModelConfiguration
     * @param TableInterface $table
     * @param FormTable $form
     */
    public function registerDatatable (TableInterface $table, FormTable $form, Request $request)
    {
        //dump(get_class_methods(DB::connection()->getName()));
        $this->request = $request;
        $table->objConfig = $this->objConfig;
        $table->admin = $this;

        $this->setTableColumnsType();

    }

    /**
     * @param $recuest
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
        $this->getObjConfig ();
    }

    public function getRequest () {
        return $this->request;
    }


    /**
     *todo create array table name column and type
     */
    public function setTableColumnsType ()
    {
        $table = $this->objConfig->getModelObj()->getTable();
        $this->TableColumns = DB::connection()->getSchemaBuilder()->getColumnListing($table);
        foreach ($this->TableColumns as $item) {
            $this->TableTypeColumns[$item] = DB::connection()->getSchemaBuilder()->getColumnType($table, $item);
        }

    }

}