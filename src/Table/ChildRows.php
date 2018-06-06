<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 31.05.18
 * Time: 14:16
 */

namespace Trafik8787\LaraCrud\Table;


use Illuminate\Http\Request;
use Closure;
use Trafik8787\LaraCrud\Contracts\ChildRowsInterface;

class ChildRows implements ChildRowsInterface
{
    protected $request;
    protected $model;
    protected $view = 'lara::Table.child_rows';
    public $closure;

    /**
     * ChildRows constructor.
     * @param Request $request
     */
    public function __construct($request, Closure $closure = null)
    {
        $this->closure = $closure;

        if ($closure === null) {
            $this->closure = true;
        }

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
        $this->model = $model->find($this->request['id']);
        return $this;
    }

    /**
     * @param $objConfig
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function render($objConfig)
    {

        $result = view($this->view, ['model' => $this->model]);

        if ($this->closure !== true and $this->closure !== null) {
            $result_closure = $this->closure->call($this, $this->model, view($this->view));
            return $result_closure ? $result_closure : $result;
        }

        return $result;

    }


}