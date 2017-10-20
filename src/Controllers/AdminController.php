<?php

namespace Trafik8787\LaraCrud\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;

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
    public function showTable (TableInterface $table, AdminInterface $admin, FormManagerInterface $form) {

        if ($admin->objConfig->getFormShow() !== null) {
            return $form->renderFormEdit($admin->objConfig->getFormShow());
        }

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
        return $form->renderFormEdit();
    }


    /**
     * @param FormManagerInterface $form
     * @return mixed
     * todo обновление записи в базе
     */
    public function postUpdate (FormManagerInterface $form)
    {
        return $form->updateForm();
    }


    /**
     * @param FormManagerInterface $form
     * @return mixed
     */
    public function showCreate (FormManagerInterface $form)
    {
        return $form->renderFormInsert();
    }

    /**
     * @param FormManagerInterface $form
     * @return mixed
     */
    public function postStore (FormManagerInterface $form)
    {
        return $form->insertForm();
    }

    /**
     * @param TableInterface $table
     * @param AdminInterface $admin
     * @return mixed
     */
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
