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

    /**
     * ChildRows constructor.
     * @param Request $request
     */
    public function __construct (Request $request) {

        $this->request = $request;
    }

    /**
     * @param null $view
     * @return $this|mixed
     */
    public function view($view = null)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @param null $model
     * @return $this|mixed
     */
    public function model($model = null)
    {
        $this->model = $model->find($this->request->input('id'));
        return $this;
    }

    /**
     * @param $objConfig
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function render($objConfig)
    {

        $result = $objConfig->SetShowChildRows($this->model, view($this->view));
        if ($result === true) {
            return view($this->view, ['model' => $this->model]);
        }

        return $result;

    }


}