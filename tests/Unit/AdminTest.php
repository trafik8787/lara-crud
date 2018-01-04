<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 01.12.2017
 * Time: 21:20
 */

namespace Trafik8787\LaraCrud\Tests\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Mockery;
use Tests\TestCase;
use Trafik8787\LaraCrud\Admin;
use Trafik8787\LaraCrud\Contracts\NodeInterface;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;

class AdminTest extends TestCase
{

    public $admin;

    public function tearDown()
    {
        Mockery::close();
    }

    public function setUp() {

        parent::setUp();

        $route = new RouteTest();
        $route->action['as'] = '';
        $route->parameters['adminModel'] = 'node_model_classs_test';
        $this->admin = new Admin([NodeModelClasssTest::class => NodeClassTest::class], ['App\Http\Node\ContactNode' =>
            [
                'priory' => 1,
                'title' => 'Contact',
                'icon' => 'fa-user-secret'
            ]], $this->app, $route);
    }

    public function test_getDefaultUrlArr() {
        $this->assertNotEmpty($this->admin->getDefaultUrlArr('node_model_classs_test'));
    }

    public function test_initNode ()
    {
        $this->assertNotEmpty($this->admin->defaultUrlArr);
        $this->assertNotEmpty($this->admin->nameModelArr);
    }

    public function test_initNodeClass ()
    {
        $this->assertNotEmpty($this->admin->objConfig);
    }

}
class NodeClassTest extends NodeModelConfiguration implements NodeInterface {


    public function showDisplay()
    {
        $this->setTitle('sd');
    }

    public function showEditDisplay()
    {
        // TODO: Implement showEditDisplay() method.
    }

    public function showInsertDisplay()
    {
        // TODO: Implement showInsertDisplay() method.
    }

    public function showDelete()
    {
        // TODO: Implement showDelete() method.
    }
}
class NodeModelClasssTest extends Model {}
class RouteTest {
    public $action;
    public $parameters;

}

