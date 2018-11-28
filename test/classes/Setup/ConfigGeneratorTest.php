<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * tests for methods under Config file generator
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Setup;

use PhpMyAdmin\Config;
use PhpMyAdmin\Config\ConfigFile;
use PhpMyAdmin\Setup\ConfigGenerator;
use PhpMyAdmin\Tests\PmaTestCase;

/**
 * Tests for PhpMyAdmin\Setup\ConfigGenerator
 *
 * @package PhpMyAdmin-test
 */
class ConfigGeneratorTest extends PmaTestCase
{
    /**
     * Test for ConfigGenerator::getConfigFile
     *
     * @return void
     * @group medium
     */
    public function testGetConfigFile()
    {
        unset($_SESSION['eol']);

        $GLOBALS['PMA_Config'] = new Config();

        $GLOBALS['server'] = 0;
        $cf = new ConfigFile();
        $_SESSION['ConfigFile0'] = ['a', 'b', 'c'];
        $_SESSION['ConfigFile0']['Servers'] = [
            [1, 2, 3],
        ];

        $cf->setPersistKeys(["1/", 2]);

        $result = ConfigGenerator::getConfigFile($cf);

        $this->assertContains(
            "<?php\n" .
            "/*\n" .
            " * Generated configuration file\n" .
            " * Generated by: phpMyAdmin " .
            $GLOBALS['PMA_Config']->get('PMA_VERSION') . " setup script\n",
            $result
        );

        $this->assertContains(
            "/* Servers configuration */\n" .
            '$i = 0;' . "\n\n" .
            "/* Server: localhost [0] */\n" .
            '$i++;' . "\n" .
            '$cfg[\'Servers\'][$i][\'0\'] = 1;' . "\n" .
            '$cfg[\'Servers\'][$i][\'1\'] = 2;' . "\n" .
            '$cfg[\'Servers\'][$i][\'2\'] = 3;' . "\n\n" .
            "/* End of servers configuration */\n\n",
            $result
        );

        $this->assertContains(
            '?>',
            $result
        );
    }

    /**
     * Test for ConfigGenerator::_getVarExport
     *
     * @return void
     */
    public function testGetVarExport()
    {
        $reflection = new \ReflectionClass('PhpMyAdmin\Setup\ConfigGenerator');
        $method = $reflection->getMethod('_getVarExport');
        $method->setAccessible(true);

        $this->assertEquals(
            '$cfg[\'var_name\'] = 1;' . "\n",
            $method->invoke(null, 'var_name', 1, "\n")
        );

        $this->assertEquals(
            '$cfg[\'var_name\'] = array (' .
            "\n);\n",
            $method->invoke(null, 'var_name', [], "\n")
        );

        $this->assertEquals(
            '$cfg[\'var_name\'] = array(1, 2, 3);' . "\n",
            $method->invoke(
                null,
                'var_name',
                [1, 2, 3],
                "\n"
            )
        );

        $this->assertEquals(
            '$cfg[\'var_name\'][\'1a\'] = \'foo\';' . "\n" .
            '$cfg[\'var_name\'][\'b\'] = \'bar\';' . "\n",
            $method->invoke(
                null,
                'var_name',
                [
                    '1a' => 'foo',
                    'b' => 'bar',
                ],
                "\n"
            )
        );
    }

    /**
     * Test for ConfigGenerator::_isZeroBasedArray
     *
     * @return void
     */
    public function testIsZeroBasedArray()
    {
        $reflection = new \ReflectionClass('PhpMyAdmin\Setup\ConfigGenerator');
        $method = $reflection->getMethod('_isZeroBasedArray');
        $method->setAccessible(true);

        $this->assertFalse(
            $method->invoke(
                null,
                [
                    'a' => 1,
                    'b' => 2,
                ]
            )
        );

        $this->assertFalse(
            $method->invoke(
                null,
                [
                    0 => 1,
                    1 => 2,
                    3 => 3,
                ]
            )
        );

        $this->assertTrue(
            $method->invoke(
                null,
                []
            )
        );

        $this->assertTrue(
            $method->invoke(
                null,
                [1, 2, 3]
            )
        );
    }

    /**
     * Test for ConfigGenerator::_exportZeroBasedArray
     *
     * @return void
     */
    public function testExportZeroBasedArray()
    {
        $reflection = new \ReflectionClass('PhpMyAdmin\Setup\ConfigGenerator');
        $method = $reflection->getMethod('_exportZeroBasedArray');
        $method->setAccessible(true);

        $arr = [1, 2, 3, 4];

        $result = $method->invoke(null, $arr, "\n");

        $this->assertEquals(
            'array(1, 2, 3, 4)',
            $result
        );

        $arr = [1, 2, 3, 4, 7, 'foo'];

        $result = $method->invoke(null, $arr, "\n");

        $this->assertEquals(
            'array(' . "\n" .
            '    1,' . "\n" .
            '    2,' . "\n" .
            '    3,' . "\n" .
            '    4,' . "\n" .
            '    7,' . "\n" .
            '    \'foo\')',
            $result
        );
    }
}
