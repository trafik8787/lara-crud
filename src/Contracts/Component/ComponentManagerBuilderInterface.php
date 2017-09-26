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

    public function classStyle (string $data); //class CSS
    public function placeholder (string $data);
    public function value ($data);
    public function name (string $data);
    public function title (string $data);
    public function build(): Text;

}