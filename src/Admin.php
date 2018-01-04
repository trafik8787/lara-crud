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
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\Model\ModelRouterInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
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
    public $navigation;
    public $TableColumns = [];
    public $TableTypeColumns = [];
    public $KeyName;

    private $request; //получает обьект Request из AdminController

    /**
     * Admin constructor.
     * @param $node
     * @param Application $app
     */
    public function __construct ($node, $navigation, Application $app, $route) {
        $this->app = $app;
        $this->models = new ModelCollection();
        $this->navigation = $navigation;

        $this->route = $route;

        $this->initNode($node);
    }

    /**
     * @param array $nodes
     */
    public function initNode (array $nodes) {

        $this->nodes = $nodes;

        foreach ($this->nodes as  $model => $nodeClass) {

            $url = $this->setUrlDefaultModel($model, $nodeClass);

            $this->defaultUrlArr[$url] = $nodeClass;
            $this->nameModelArr[$url] = $model;

        }

        $this->setRoute();
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getDefaultUrlArr ($url)
    {
        return $this->defaultUrlArr[$url];
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getNameModelArr($url)
    {
        return $this->nameModelArr[$url];
    }

    /**
     * @param string $strModelName
     * @return string
     * преобразуем название модели в URL
     */
    public function setUrlDefaultModel (string $strModelName, $nodeClass)
    {
        $url = snake_case(class_basename($strModelName));

        if (!empty($nodeClass::$alias_url)) {
            $url = str_slug($nodeClass::$alias_url, '-');
        }

        return $url;
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
     * @return mixed|void
     */
    public function getObjConfig ()
    {

        if ($this->route->action['as'] === 'Dashboard') {

            $url = config('lara-config.url_group');
            $obj = $this->getDefaultUrlArr($url);
            $model = $this->getNameModelArr($url);

        } else {

            if (!empty($this->getDefaultUrlArr($this->route->parameters['adminModel']))) {

                $obj = $this->getDefaultUrlArr($this->route->parameters['adminModel']);
                $model = $this->getNameModelArr($this->route->parameters['adminModel']);
            }
        }
        $this->initNodeClass(new $obj($this->app, $model)); //создает обьект $this->objConfig класса NodeModelConfigurationInterface

    }


    /**
     * @param NodeModelConfigurationInterface $modelConf
     */
    public function initNodeClass(NodeModelConfigurationInterface $modelConf)
    {

        if ($this->route->action['as'] === 'model.showTable' or
            $this->route->action['as'] === 'model.postNewAction' or
            $this->route->action['as'] === 'model.ajax.dispaly.table' or
            $this->route->action['as'] === 'Dashboard') {

            if (method_exists($modelConf, 'showDisplay')) {
                $modelConf->showDisplay();
            }

        } elseif ($this->route->action['as'] === 'model.edit' or $this->route->action['as'] === 'model.update') {
            if (method_exists($modelConf, 'showEditDisplay')) {
                $modelConf->showEditDisplay();
            }
        } elseif ($this->route->action['as'] === 'model.create' or $this->route->action['as'] === 'model.store') {
            if (method_exists($modelConf, 'showInsertDisplay')) {
                $modelConf->showInsertDisplay();
            }
        } elseif ($this->route->action['as'] === 'model.delete') {
            if (method_exists($modelConf, 'showDelete')) {
                $modelConf->showDelete();
            }
        }

        $this->setModel($modelConf->getModel(), $modelConf);

        $modelConf->admin = $this;
        $this->objConfig = $modelConf;
        $this->app->call([$this, 'registerDatatable']);

    }


    /**
     * @param TableInterface $table
     * @param FormManagerInterface $form
     * @param Request $request
     */
    public function registerDatatable (TableInterface $table, FormManagerInterface $form,  Request $request)
    {
        $this->request = $request;
        $table->objConfig = $this->objConfig;
        $table->admin = $this;

        $form->objConfig = $this->objConfig;
        $form->admin = $this;

        $this->setTableColumnsType();

    }

    /**
     * @param $recuest
     */
    public function setRoute()
    {
        $this->getObjConfig ();
    }

    /**
     * @return mixed
     */
    public function getRequest () {
        return $this->request;
    }


    /**
     * @return mixed|void
     * todo create array table name column and type
     */
    public function setTableColumnsType ()
    {
        $model = $this->objConfig->getModelObj();

        $table_name =  $model->getTable();

        /*Primary Key*/
        $this->KeyName = $model->getKeyName();

        $full_field =  DB::connection()->getSchemaBuilder()->getColumnListing($table_name);
        $this->TableColumns = array_diff($full_field, config('lara-config.field_disable'));
        foreach ($this->TableColumns as $item) {
            $this->TableTypeColumns[$item] = DB::connection()->getSchemaBuilder()->getColumnType($table_name, $item);
        }

    }

}