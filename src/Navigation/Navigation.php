<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 02.10.2017
 * Time: 16:11
 */
namespace Trafik8787\LaraCrud\Navigation;

use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\Navigation\NavigationInterface;

/**
 * Class Navigation
 * @package Trafik8787\LaraCrud\Navigation
 */
class Navigation implements NavigationInterface
{

    public $navigation = [];
    public $navigation_tab = [];
    public $admin;

    /**
     * Navigation constructor.
     * @param AdminInterface $admin
     */
    public function __construct (AdminInterface $admin) {

        $this->admin = $admin;

        $url = '/'.config('lara-config.url_group').'/';

        foreach ($this->admin->defaultUrlArr as $nodeClass => $item) {

            if ($this->admin->getNavigation($item)) {
                $naw = $this->admin->getNavigation($item);
                /**
                 * переопределяем значением из класса
                 */
                if ($this->admin->getNavigationParams($item)) {
                    $naw = array_replace($this->admin->getNavigation($item), $this->admin->getNavigationParams($item));
                }

                $this->navigation[$url.$nodeClass] = $naw;
            }

        }

        $defFlip = array_flip($this->admin->defaultUrlArr);
        if ($this->admin->getNavigation('tabs')) {

            foreach ($this->admin->getNavigation('tabs') as $NameTab => $tab) {
                $this->navigation_tab['tabs'][$NameTab]['settings'] = $tab['settings'];

                foreach ($tab['node'] as $class_node => $item) {

                    if ($this->admin->getNavigationParams($class_node)) {
                        $item = array_replace($item, $this->admin->getNavigationParams($class_node));
                    }

                    $this->navigation_tab['tabs'][$NameTab]['node'][$url . $defFlip[$class_node]] = $item;
                }

            }
        }

    }


    /**
     * @return array
     */
    public function getNavigation()
    {
        $priory=[];
        $priory_tab=[];

        if (!empty($this->navigation_tab['tabs'])) {


            foreach ($this->navigation_tab['tabs'] as $item) {
                $priory_tab[] = $item['settings']['priory'];
            }

            array_multisort($priory_tab, SORT_ASC, $this->navigation_tab['tabs']);
        }

        foreach ($this->navigation as $row) {
            $priory[] = $row['priory'];
        }

        array_multisort($priory, SORT_ASC, $this->navigation);

        $this->navigation = array_merge($this->navigation, $this->navigation_tab);

        return $this->navigation;
    }

    /**
     * @param View $view
     */
    public function compose(View $view) {

        $view->with('navigate', $this->navigateViews());
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function navigateViews ()
    {
        return view('lara::layouts.navigation', ['nav' => $this->getNavigation()]);
    }

}