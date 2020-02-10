<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/15/2019
 * Time: 5:20 PM
 */

namespace JimLog\Tests;



use JimLog\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function testT1()
    {
        Config::loadIni();
        print_r(Config::getAndImplode(['domain', 'get_course']));
        $this->assertEquals(1, 1);
    }
}
