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


    public function __construct(Request $request, AdminInterface $admin, Application $application, Route $route) {


        $this->configNode = $admin->getObjConfig($route);
        $this->app = $application;
        $this->model = $this->configNode->getModelObj();



    }

    public function showTable (TableInterface $table) {

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
        return $table->render();


    }

    public function inlineTable (Request $request, TableInterface $table)
    {
//        $table->setRequest($request->input());
       //dump($table->getRequest());
        //dd($table->);
        //$this->configNode->setRequest($request->input());

        //ddd($request->input('columns'));
        //ddd($request->input('columns'));


      return Response::json([
           'draw' => 1,
           'recordsTotal' => 2,
           'recordsFiltered' => 2,
                'data' => [
                    [
                       'first_name' => 'Airi',
                      'last_name' => 'Satou',
                      'position' => 'Accountant',
                      'office' => 'Tokyo',
                      'start_date' => '28th Nov 08',
                      'salary' => '$162,700'
                    ],
                    [
                        'first_name' => 'Airi',
                        'last_name' => 'Satou',
                        'position' => 'Accountant',
                        'office' => 'Tokyo',
                        'start_date' => '28th Nov 08',
                        'salary' => '$162,700'
                    ]
                ]
       ]);

    }

    public function showEdit (FormTable $form)
    {
//        dump($form);
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
