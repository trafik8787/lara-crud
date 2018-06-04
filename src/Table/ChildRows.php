<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 31.05.18
 * Time: 14:16
 */

namespace Trafik8787\LaraCrud\Table;


use Illuminate\Http\Request;
use Trafik8787\LaraCrud\Contracts\ChildRowsInterface;

class ChildRows implements ChildRowsInterface
{
    protected $request;
    protected $model;
    protected $arrayNameColumns;
    protected $view = 'lara::Table.child_rows';

    public function __construct (Request $request) {

        $this->request = $request;
    }

    public function view($view = null)
    {
        $this->view = $view;
        return $this;
    }

    public function model($model = null)
    {
        $this->model = $model->find($this->request->input('id'));
        return $this;
    }

    public function render($objConfig)
    {
       // dd( $objConfig->nameColumns());
        $result =  $objConfig->SetShowChildRows($this->model, view($this->view));
        if ($result === true) {
            return view($this->view, ['model' => $this->model]);
        }

        return $result;

    }

}