<?php

namespace Trafik8787\LaraCrud\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;

class AdminController extends Controller
{

//    public function showProfile(AdminInterface $admin) {
//
//        return $admin->getClass();
//    }
    public $paramUrlNameModel;
    public $configNode;
    public $app;
    private $model;


    public function __construct(Request $request, AdminInterface $admin, Application $application, Route $route) {
        //dd($request->adminModel);
        $this->configNode = $admin->getObjConfig($route);
        $this->app = $application;
        $this->model = $this->configNode->getModelObj();

    }

    public function showTable ($url) {
//    public function showTable () {
//    public function showTable ( $urlNameModel) {


        dump($this->model->all());

        return view('lara::test', ['nameModel' =>  $this->configNode->getTitle()]);

    }

    public function showEdit ()
    {
        //dump($this->configNode);
        $model = $this->configNode->getModelObj()->find(1);
       
     //   dd($model->firstname);
       $model->firstname = 'ggggggggggggggggsssssssssaaaaa/////////////////--';
       $model->save();
    }

    public function showCreate ()
    {

    }

    public function postStore ()
    {

    }
}
