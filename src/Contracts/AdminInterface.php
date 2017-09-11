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


//    public function getClass ();
    public function setModel($class, NodeModelConfigurationInterface $modelConf);

    public function setUrlDefaultModel (string $strModelName);

    public function initNode(array $nodes);

//    public function initNodeClass (NodeModelConfigurationInterface $modelConf);
    public function initNodeClass (NodeModelConfigurationInterface $modelConf);

    public function getModels();

    public function getObjConfig($url);


//    public function configNodeModel ();


//    public function initNodeModel ($obj);

}