<?php
namespace  Trafik8787\LaraCrud\Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Trafik8787\LaraCrud\Admin;

class ExampleTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testErt ()
    {
        $this->assertTrue(true);
    }

    public function testM()
    {
        $mock = Mockery::mock(Admin::class);
        $mock->shouldReceive('setUrlDefaultModel')->with('nameModel')->andReturn(true);
    }
}
