<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 11.09.2017
 * Time: 16:00
 */

namespace Trafik8787\LaraCrud\Table;


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
use Trafik8787\LaraCrud\Models\NodeModelConfigurationManager;

class DataTable implements TableInterface
{

    public $objModel;
    private $request;

    public function __construct (Application $app) {
        //получаем обект модели

        //$this->objModel = $configNode->getModelObj();
       // ddd($configNode->getModelObj());
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render ()
    {
        //dd($this->getColumn());
        return view('lara::Table.table');
    }

    /**
     * @return array
     * todo получить
     */
    public function getColumn ()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->objModel->getModelObj()->getTable());
    }

    public function setRequest ($request) {
        $this->request = $request;
        $model = $this->objModel->getModelObj();
        $model = $model->find(1);
        //dump($model->id);
    }

    public function getRequest ()
    {
        return $this->request;
    }
}