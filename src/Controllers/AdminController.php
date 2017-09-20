<?php

namespace Trafik8787\LaraCrud\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Table\DataTable;

class AdminController extends Controller
{

//DB::listen(function($sql, $bindings, $time) {
//    var_dump($sql);
//    var_dump($bindings);
//    var_dump($time);
//});
//

//    public function showProfile(AdminInterface $admin) {
//
//        return $admin->getClass();
//    }
    public $paramUrlNameModel;
    public $configNode;
    public $app;
    private $model;
    private $dataTable;
    private $request;
    protected $admin;

    public function __construct(Request $request, AdminInterface $admin, Application $application, TableInterface $table) {


//        $this->configNode = $admin->getObjConfig($route, $request->input());
//        $this->app = $application;
//        $this->model = $this->configNode->getModelObj();
        /*Добавляем обьект запроса в класс Admin*/
       // $admin->setRequest($request->input());
        //dump($this->configNode);
        //$request->qweqweqwe = $admin->objConfig->getTitle();

       // dump($admin->objConfig->getTitle());
    }

    public function showTable (TableInterface $table, AdminInterface $admin) {

        //$table->setRequest($this->request);
       // dd($this->model->paginate(2)->toArray());
       // dump($table);
        //ddd($request->input(''));
        //$this->configNode->objDataTable->setRequest($request->input());
//        dump('1');
//        dump(DB::getSchemaBuilder()->hasTable('contacts'));

      //  dump($this->model->getTable());
      //  dump(get_class_methods(DB::getSchemaBuilder()));
        //dump(get_class_methods($this->model));

       // dump($this->dataTable->getColumn());
//        dump($table->obj);
//        foreach ($this->model->all() as $item) {
//            dump($item);
//        }
        //dump($this->configNode->objDataTable->getColumn());
        //dump(get_class_methods($this->configNode));
        return $table->render($admin);
//

    }


    public function inlineTable (TableInterface $table, AdminInterface $admin)
    {
        //dd($request);
        //$table->setRequest($request->input());
       //dump($table->getRequest());
        //dd($table->);
        //$this->configNode->setRequest($request->input());

        //ddd($request->input('columns'));
        //ddd($request->input('columns'));
        //dump($admin);
        return $table->jsonResponseTable($admin);

    }

    public function showEdit (FormTable $form)
    {
        //dump($form);
//        $model = $this->configNode->getModelObj()->find(1);
//
//        //   dd($model->firstname);
//        $model->firstname = 'ggggggggggggggggsssssssssaaaaa/////////////////--';
//        $model->save();
        return $form->formRender();
    }

    public function showCreate ()
    {

    }

    public function postStore ()
    {

    }
}
