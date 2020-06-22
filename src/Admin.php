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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Models\HomeModel;
use Trafik8787\LaraCrud\Models\HomeNode;
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
    private $NavigationParams;
    private $request; //получает обьект Request из AdminController

    /**
     * Admin constructor.
     * @param $node
     * @param Application $app
     */
    public function __construct($node, $navigation, Application $app, $route)
    {
        $this->app = $app;
        $this->models = new ModelCollection();
        $this->navigation = $navigation;
        $this->route = $route;

        $this->initNode($node);
    }

    /**
     * @param array $nodes
     */
    public function initNode(array $nodes)
    {

        $this->nodes = $nodes;

        foreach ($this->nodes as $model => $nodeClass) {

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
    public function getDefaultUrlArr($url)
    {
        if (!empty($this->defaultUrlArr[$url])) {
            return $this->defaultUrlArr[$url];
        }
        return false;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getNameModelArr($url)
    {
        if (!empty($this->nameModelArr[$url])) {
            return $this->nameModelArr[$url];
        }

        return false;
    }

    /**
     * @param string $strModelName
     * @return string
     * преобразуем название модели в URL
     */
    public function setUrlDefaultModel(string $strModelName, $nodeClass)
    {
        $url = Str::snake(class_basename($strModelName));

        //переопределяем параметры меню
        $this->setNavigationParams($nodeClass);

        if (!empty($nodeClass::$alias_url)) {
            $url = str_slug($nodeClass::$alias_url, '-');
        }

        return $url;
    }


    /**
     * @param $nodeClass
     * @return bool
     */
    public function getNavigation($nodeClass)
    {

        if (!empty($this->navigation[$nodeClass])) {
            return $this->navigation[$nodeClass];
        }

        return false;
    }


    /**
     * @param $nodeClass
     */
    public function setNavigationParams($nodeClass)
    {
        if (!empty($nodeClass::$navigation_title)) {
            $this->NavigationParams[$nodeClass] = [
                'title' => $nodeClass::$navigation_title
            ];
        }
    }


    /**
     * @param $nodeClass
     * @return bool
     */
    public function getNavigationParams($nodeClass)
    {
        if (!empty($this->NavigationParams[$nodeClass])) {
            return $this->NavigationParams[$nodeClass];
        }
        return false;
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
    public function getObjConfig()
    {

        if ($this->route->action['as'] === 'Dashboard') {

            $url = config('lara-config.url_group');

            if ($this->getDefaultUrlArr($url)) {
                $obj = $this->getDefaultUrlArr($url);
            } else {
                $obj = HomeNode::class;
            }

            if ($this->getNameModelArr($url)) {
                $model = $this->getNameModelArr($url);
            } else {
                $model = HomeModel::class;
            }


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
    public function registerDatatable(TableInterface $table, FormManagerInterface $form, Request $request)
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
        $this->getObjConfig();
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }


    /**
     * @return mixed|void
     * todo create array table name column and type
     */
    public function setTableColumnsType()
    {
        $model = $this->objConfig->getModelObj();

        $table_name = $model->getTable();

        /*Primary Key*/
        $this->KeyName = $model->getKeyName();

        $full_field = DB::connection()->getSchemaBuilder()->getColumnListing($table_name);

        $fieldDisable = config('lara-config.field_disable');

        if (!empty($this->objConfig->getFieldDisable()))
        {
            $fieldDisable = $this->objConfig->getFieldDisable();
        }


        $this->TableColumns = array_diff($full_field, $fieldDisable);

        foreach ($this->TableColumns as $item) {
            $this->TableTypeColumns[$item] = DB::connection()->getSchemaBuilder()->getColumnType($table_name, $item);
        }

    }

}
