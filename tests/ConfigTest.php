<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/15/2019
 * Time: 5:20 PM
 */

namespace JimLog\Tests;



use Composer\Autoload\ClassLoader;
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
        debug(Config::get('get_course'));
        print_r(Config::getAndImplode(['domain', 'get_course']));
        $this->assertEquals(1, 1);
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function getAppPath()
    {
        $filename = (new \ReflectionClass(ClassLoader::class))->getMethods()[0]->getDeclaringClass()->getFilename();
        $appPath = substr($filename, 0, strpos($filename, '/vendor/'));
    }
}
