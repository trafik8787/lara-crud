<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 13:34
 */
namespace Trafik8787\LaraCrud\Contracts\Component;

use Trafik8787\LaraCrud\Form\Component\Text;

interface ComponentManagerBuilderInterface
{

    /**
     * @return mixed
     */
    public function classStyle (); //class CSS

    /**
     * @return mixed
     */
    public function placeholder ();

    /**
     * @param $data
     * @return mixed
     */
    public function value ($data);

    /**
     * @return mixed
     */
    public function type ();

    /**
     * @return mixed
     */
    public function label ();

    /**
     * @return mixed
     */
    public function name ();

    /**
     * @return mixed
     */
    public function title ();

    /**
     * @return mixed
     */
    public function build();

}