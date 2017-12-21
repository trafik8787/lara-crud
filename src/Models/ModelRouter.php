<?php

namespace Trafik8787\LaraCrud\Models;

use Illuminate\Routing\Route;
use Trafik8787\LaraCrud\Contracts\Model\ModelRouterInterface;

class ModelRouter implements ModelRouterInterface
{

    private $route;

    public function __construct (Route $route) {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }
}
