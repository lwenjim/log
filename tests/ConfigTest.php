<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/15/2019
 * Time: 5:20 PM
 */

namespace Test;



use JimLog\Config;

class ConfigTest extends Abs
{
    /**
     * @test
     */
    public function testT1()
    {
        Config::loadIni();
        print_r(Config::getInstance()->getAndImplode(['domain_course', 'get_course_info']));
        $this->assertEquals(1, 1);
    }
}
