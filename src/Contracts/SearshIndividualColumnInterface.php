<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 02.02.19
 * Time: 21:41
 */

namespace Trafik8787\LaraCrud\Contracts;


use Trafik8787\LaraCrud\Models\NodeModelConfigurationManager;

interface SearshIndividualColumnInterface
{

    /**
     * SearshIndividualColumnInterface constructor.
     * @param $arrColumn
     * @param NodeModelConfigurationManager $configurationManager
     */
    public function __construct($arrColumn, NodeModelConfigurationManager $configurationManager);

    /**
     * @return mixed
     */
    public function render();

    /**
     * @param $column
     * @return mixed
     */
    public function column($column);

    /**
     * @param $column
     * @return mixed
     */
    public function getColumns();


}