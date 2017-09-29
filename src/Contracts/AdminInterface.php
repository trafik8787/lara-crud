<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:20
 */

namespace Trafik8787\LaraCrud\Contracts;


use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Trafik8787\LaraCrud\Form\FormTable;

interface AdminInterface
{
    /**
     * @param $class
     * @param NodeModelConfigurationInterface $modelConf
     * @return mixed
     */
    public function setModel($class, NodeModelConfigurationInterface $modelConf);

    /**
     * @param string $strModelName
     * @return mixed
     */
    public function setUrlDefaultModel (string $strModelName);

    /**
     * @param array $nodes
     * @return mixed
     */
    public function initNode(array $nodes);

    /**
     * @param NodeModelConfigurationInterface $modelConf
     * @return mixed
     */
    public function initNodeClass (NodeModelConfigurationInterface $modelConf); //init class Node

    /**
     * @return mixed
     */
    public function getModels(); //collection models

    /**
     * @return mixed
     */
    public function getObjConfig(); //object class NodeModelConfiguration

    /**
     * @param Route $route
     * @return mixed
     */
    public function setRoute (Route $route);

    /**
     * @param TableInterface $table
     * @param FormManagerInterface $form
     * @param Request $request
     * @return mixed
     */
    public function registerDatatable (TableInterface $table, FormManagerInterface $form, Request $request);

    /**
     * @return mixed
     */
    public function setTableColumnsType ();
}