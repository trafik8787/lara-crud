<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:41
 */

namespace Trafik8787\LaraCrud;

use Illuminate\Contracts\Foundation\Application;
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
    public $modelConfig;
    public $models;
    public $route;
    public $objConfig;

    public function __construct (Application $app) {
        $this->app = $app;
        $this->models = new ModelCollection();
        $this->registerCoreContainerAliases();
    }

    /**
     * @param array $nodes
     * todo инициализация Node классов
     */
    public function initNode (array $nodes)
    {

        $this->nodes = $nodes;

        foreach ($this->nodes as  $model => $nodeClass) {

            $url = $this->setUrlDefaultModel($model);
            $this->defaultUrlArr[$url] = $nodeClass;
            $this->nameModelArr[$url] = $model;

        }

    }


    //преобразуем название модели в URL

    /**
     * @param string $strModelName
     * @return string
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
     * @param $route
     * @return mixed
     */
    public function getObjConfig ($route)
    {
        $this->route = $route;
        if (!empty($this->defaultUrlArr[$route->parameters['adminModel']])) {

            $obj = $this->defaultUrlArr[$route->parameters['adminModel']];
            $model = $this->nameModelArr[$route->parameters['adminModel']];
            $this->initNodeClass(new $obj($this->app, $model)); //создает обьект $this->objConfig класса NodeModelConfigurationInterface

        }

        return $this->objConfig;
    }

    /**
     * @param $nodeClass
     */
    public function initNodeClass(NodeModelConfigurationInterface $modelConf)
    {
        $this->objConfig = $modelConf;
        $this->objConfig->objRoute = $this->route;
        $this->setModel($modelConf->getModel(), $modelConf);

        $this->registerMetodNodeClass();

        $this->app->call([$this, 'registerDatatable']);
        return $this;
    }

//
    public function registerDatatable (TableInterface $table, FormTable $form)
    {

        $table->objModel = $this->objConfig;
        $form->injectObjConfig($this->objConfig);

    }

    /**
     * вызов методов в классе
     * showEditDisplay()
     * showDisplay()
     * showInsertDisplay()
     */
    public function registerMetodNodeClass()
    {

        //dd($this->getModels());
        if ($this->objConfig->objRoute->action['as'] === 'model.showTable') {

            if (method_exists($this->objConfig, 'showDisplay')) {
                $this->objConfig->showDisplay();
            }
        } elseif ($this->objConfig->objRoute->action['as'] === 'model.edit') {
            if (method_exists($this->objConfig, 'showEditDisplay')) {
                $this->objConfig->showEditDisplay();
            }
        } elseif ($this->objConfig->objRoute->action['as'] === 'model.create') {
            if (method_exists($this->objConfig, 'showInsertDisplay')) {
                $this->objConfig->showInsertDisplay();
            }
        }


    }


    /**
     * регистрация алиасов классов к интерфейсам
     *
     */
    protected function registerCoreContainerAliases() {

        $aliases = [
            'lara_form' => ['Trafik8787\LaraCrud\Form\FormTable', 'Trafik8787\LaraCrud\Contracts\FormManagerInterface'],
            'lara_admin_nodemodel' => ['Trafik8787\LaraCrud\Models\NodeModelConfiguration', 'Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface'],
            'lara_admin' => ['Trafik8787\LaraCrud\Admin', 'Trafik8787\LaraCrud\Contracts\AdminInterface'],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }


}