<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 06.06.18
 * Time: 9:47
 */

namespace Trafik8787\LaraCrud\Table;

use Illuminate\Http\Request;
use Trafik8787\LaraCrud\Contracts\ActionTableInterface;

class ActionTable implements ActionTableInterface
{
    protected $id;
    protected $objConfig;
    protected $view = 'lara::Form.action';
    protected $actionEdit;


    /**
     * ActionTable constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $objConfig
     */
    public function objConfig($objConfig)
    {
        $this->objConfig = $objConfig;
        return $this;
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function render(int $id)
    {
        $this->id = $id;
        return view($this->view, ['id' => $this->id, 'configNode' => $this->objConfig, 'actionEdit' => $this->actionEdit])->render();
    }


    /**
     * @param $value
     * @return $this
     */
    public function beforeShowButtonEdit ($value)
    {
        $this->actionEdit = $value;
        return $this;
    }


    /**
     * @return bool
     */
    public function enableColumnAction(): bool
    {
        if (!$this->objConfig->getButtonDelete()
            and !$this->objConfig->getNewAction()
            and empty($this->objConfig->buttonEditClosure)) {

            return false;
        }

        return true;
    }


}