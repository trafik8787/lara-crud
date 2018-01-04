<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 21.12.2017
 * Time: 15:54
 */

namespace Trafik8787\LaraCrud\Tests\Unit\Form;
use Mockery;
use Tests\TestCase;
use Trafik8787\LaraCrud\Form\FormTable;


class FormTableTest extends TestCase
{


    public function tearDown()
    {
        Mockery::close();
    }


    public function testSaveRelationTableOneToMany ()
    {
        $mock = Mockery::mock(FormTable::class);
        $mock->shouldReceive('saveRelationTableOneToMany')
            ->with('namefield', 2, 2)
            ->andReturn(true);
           // ->andReturn($this->assertNotEmpty());
        //dd($mock->andReturn(true));
    }
}