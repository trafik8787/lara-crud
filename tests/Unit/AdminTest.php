<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 01.12.2017
 * Time: 21:20
 */

namespace Trafik8787\LaraCrud\Tests\Unit;
use Mockery;
use Tests\TestCase;
use Trafik8787\LaraCrud\Admin;

class AdminTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testM()
    {
        $mock = Mockery::mock(Admin::class);
        $mock->shouldReceive('setUrlDefaultModel')->with('nameModel')->andReturn(true);
    }

}