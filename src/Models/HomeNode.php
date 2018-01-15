<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 15.01.2018
 * Time: 18:46
 */

namespace Trafik8787\LaraCrud\Models;


class HomeNode extends NodeModelConfiguration {

    public function showDisplay ()
    {
        return view('lara::Table.home');
    }

}