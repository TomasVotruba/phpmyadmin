<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for PhpMyAdmin\Di\Container class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Di;

use PhpMyAdmin\Di\Container;
use PhpMyAdmin\Tests\PmaTestCase;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Tests for PhpMyAdmin\Di\Container class
 *
 * @package PhpMyAdmin-test
 */
class ContainerTest extends PmaTestCase
{
    /**
     * @access protected
     */
    protected $container;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->container = new Container();
    }

    /**
     * Tears down the fixture.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        unset($this->container);
    }

    /**
     * Test for get
     */
    public function testGetWithValidEntry()
    {
        $this->container->set('name', 'value');
        $this->assertSame('value', $this->container->get('name'));
    }

    /**
     * Test for get
     */
    public function testGetThrowsNotFoundException()
    {
        $this->expectException(NotFoundExceptionInterface::class);
        $this->container->get('name');
    }

    /**
     * Test for has
     */
    public function testHasReturnsTrueForValidEntry()
    {
        $this->container->set('name', 'value');
        $this->assertTrue($this->container->has('name'));
    }

    /**
     * Test for has
     */
    public function testHasReturnsFalseForInvalidEntry()
    {
        $this->assertFalse($this->container->has('name'));
    }
}
