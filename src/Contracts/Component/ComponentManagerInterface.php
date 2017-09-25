<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 13:34
 */
namespace Trafik8787\LaraCrud\Contracts\Component;

interface ComponentManagerInterface
{

    public function classStyle (); //class CSS
    public function placeholder ();
    public function type (); // type input
    public function value ();
    public function name ();
    public function title ();

}