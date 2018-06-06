<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 02.10.2017
 * Time: 16:13
 */

namespace Trafik8787\LaraCrud\Contracts\Navigation;

use Illuminate\View\View;

interface NavigationInterface
{

    /**
     * @param View $view
     * @return mixed
     */
    public function compose(View $view);

    /**
     * @return mixed
     */
    public function getNavigation();


}