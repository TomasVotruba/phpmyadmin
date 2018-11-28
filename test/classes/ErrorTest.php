<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for Error.php
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests;

use PhpMyAdmin\Error;

/**
 * Error class testing.
 *
 * @package PhpMyAdmin-test
 */
class ErrorTest extends PmaTestCase
{
    /**
     * @var Error
     * @access protected
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->object = new Error(2, 'Compile Error', 'error.txt', 15);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * Test for setBacktrace
     */
    public function testSetBacktrace()
    {
        $bt = [['file' => 'bt1', 'line' => 2, 'function' => 'bar', 'args' => ['foo' => $this]]];
        $this->object->setBacktrace($bt);
        $bt[0]['args']['foo'] = '<Class:PhpMyAdmin\Tests\ErrorTest>';
        $this->assertEquals($bt, $this->object->getBacktrace());
    }

    /**
     * Test for setLine
     */
    public function testSetLine()
    {
        $this->object->setLine(15);
        $this->assertEquals(15, $this->object->getLine());
    }

    /**
     * Test for setFile
     *
     * @param string $file     actual
     * @param string $expected expected
     *
     * @dataProvider filePathProvider
     */
    public function testSetFile($file, $expected)
    {
        $this->object->setFile($file);
        $this->assertEquals($expected, $this->object->getFile());
    }

    /**
     * Data provider for setFile
     *
     * @return array
     */
    public function filePathProvider()
    {
        return [
            ['./ChangeLog', '.' . DIRECTORY_SEPARATOR . 'ChangeLog'],
            [
                __FILE__,
                '.' . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'ErrorTest.php',
            ],
            ['./NONEXISTING', 'NONEXISTING'],
        ];
    }

    /**
     * Test for getHash
     */
    public function testGetHash()
    {
        $this->assertEquals(
            1,
            preg_match('/^([a-z0-9]*)$/', $this->object->getHash())
        );
    }

    /**
     * Test for getBacktraceDisplay
     */
    public function testGetBacktraceDisplay()
    {
        $this->assertContains(
            'PHPUnit\Framework\TestResult->run(<Class:PhpMyAdmin\Tests\ErrorTest>)<br />',
            $this->object->getBacktraceDisplay()
        );
    }

    /**
     * Test for getDisplay
     */
    public function testGetDisplay()
    {
        $this->assertContains(
            '<div class="error"><strong>Warning</strong>',
            $this->object->getDisplay()
        );
    }

    /**
     * Test for getHtmlTitle
     */
    public function testGetHtmlTitle()
    {
        $this->assertEquals('Warning: Compile Error', $this->object->getHtmlTitle());
    }

    /**
     * Test for getTitle
     */
    public function testGetTitle()
    {
        $this->assertEquals('Warning: Compile Error', $this->object->getTitle());
    }

    /**
     * Test for getBacktrace
     */
    public function testGetBacktrace()
    {
        $bt = [
            ['file' => 'bt1', 'line' => 2, 'function' => 'bar', 'args' => ['foo' => 1]],
            ['file' => 'bt2', 'line' => 2, 'function' => 'bar', 'args' => ['foo' => 2]],
            ['file' => 'bt3', 'line' => 2, 'function' => 'bar', 'args' => ['foo' => 3]],
            ['file' => 'bt4', 'line' => 2, 'function' => 'bar', 'args' => ['foo' => 4]],
        ];

        $this->object->setBacktrace($bt);

        // case: full backtrace
        $this->assertCount(4, $this->object->getBacktrace());

        // case: first 2 frames
        $this->assertCount(2, $this->object->getBacktrace(2));
    }
}
