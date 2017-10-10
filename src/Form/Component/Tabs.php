<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 09.10.2017
 * Time: 18:29
 */
namespace Trafik8787\LaraCrud\Form\Component;
use Trafik8787\LaraCrud\Contracts\Component\TabsInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;

class Tabs implements TabsInterface
{

    private $objConfig;
    private $name = [];
    private $allNameFieldTabs = []; //все поля которые попали в вкладки
    private $no_tab = [];

    public function name()
    {
        // TODO: Implement name() method.
    }

    public function build($result)
    {
        if (!empty($this->objConfig->getTab())) {
            foreach ($this->objConfig->getTab() as $nameTab => $item) {

                //формирование масива отрендеренных полей
                $this->TabFore1($result, $nameTab, $item);
                //получаем масив полей которые попали в вкладки
                $this->allNameFieldTabs = array_merge($this->allNameFieldTabs, $item);
            }

            $this->allNameFieldTabs = array_flip($this->allNameFieldTabs);

            //вычисляем расхождение в масивах и выделяем те поля которые не попали в вкладки
            foreach ($result as $item) {
                if (!isset($this->allNameFieldTabs[$item->name])) {
                    $this->no_tab[$item->name] = $item->run();
                }
            }
        } else {
            $this->no_tab = $result;
        }

        $data = [
            'data_tabs' => $this->name, //сортированные по вкладкам поля
            'no_tab' => $this->no_tab //поля которые не поали в вкладки
        ];

        return view('lara::Form.Component.tabs', $data);
    }


    /**
     * @param $result
     * @param $nameTab
     * @param $itam
     */
    public function TabFore1 ($result, $nameTab, $itam) {

        foreach ($result as $arr_item) {

            if (in_array($arr_item->name, $itam)) {
                $this->name[$nameTab][$arr_item->name] = $arr_item->run();
            }
        }
    }


    /**
     * @param $obj
     */
    public function objConfig($obj)
    {
        $this->objConfig = $obj;
    }
}