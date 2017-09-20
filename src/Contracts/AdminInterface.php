<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:20
 */

namespace Trafik8787\LaraCrud\Contracts;


use Illuminate\Contracts\Routing\Registrar as RegistrarContract;

interface AdminInterface
{
    public function setModel($class, NodeModelConfigurationInterface $modelConf);
    public function setUrlDefaultModel (string $strModelName);
    public function initNode(array $nodes);
    public function initNodeClass (NodeModelConfigurationInterface $modelConf); //init class Node
    public function getModels(); //collection models
    public function getObjConfig($route, $request); //object class NodeModelConfiguration

    public function setRequest ($recuest);
    public function getRequest ();

}