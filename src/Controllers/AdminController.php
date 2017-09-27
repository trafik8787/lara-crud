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
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
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

    public $paramUrlNameModel;
    public $configNode;
    public $app;
    private $model;
    private $dataTable;
    private $request;
    protected $admin;

    /**
     * AdminController constructor.
     * @param Request $request
     * @param AdminInterface $admin
     * @param Application $application
     * @param TableInterface $table
     * @param FormManagerInterface $form
     */
    public function __construct(Request $request, AdminInterface $admin, Application $application, TableInterface $table, FormManagerInterface $form) {


    }

    /**
     * @param TableInterface $table
     * @param AdminInterface $admin
     * @return mixed
     */
    public function showTable (TableInterface $table, AdminInterface $admin) {

        return $table->render();

    }


    /**
     * @param TableInterface $table
     * @param AdminInterface $admin
     * @return mixed
     */
    public function inlineTable (TableInterface $table, AdminInterface $admin)
    {

        return $table->jsonResponseTable($admin);

    }

    /**
     * @param FormManagerInterface $form
     * @param AdminInterface $admin
     * @return mixed
     */
    public function showEdit (FormManagerInterface $form, AdminInterface $admin)
    {

        //return view('lara::common.app');
        return $form->renderFormEdit();
    }

    /**
     *  todo обновление записи в базе
     */
    public function postUpdate (FormManagerInterface $form)
    {
        return $form->updateForm();
    }


    public function showCreate (FormManagerInterface $form)
    {
        return $form->renderFormInsert();
    }

    public function postStore (FormManagerInterface $form)
    {
        return $form->insertForm();
    }

    public function deleteDelete (TableInterface $table, AdminInterface $admin) {

        return $table->deleteRows($admin);
    }

    /**
     * @param TableInterface $table
     * @param AdminInterface $admin
     * todo срабатывает при нажатии на новые кнопки Action
     */
    public function postNewAction (Request $request, TableInterface $table, AdminInterface $admin)
    {

        //dump($admin);
        return $table->newAction();
    }

}
