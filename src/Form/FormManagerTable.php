<?php
namespace Trafik8787\LaraCrud\Form;
use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Form\Component\Text;

/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:07
 */

abstract class FormManagerTable implements FormManagerInterface
{
    public $objConfig;
    public $admin;
    protected $componentManager;
    protected $id;

    public function __construct (Application $app, ComponentManagerInterface $componentManager) {
        $this->componentManager = $componentManager;
        
        
        

    }


}