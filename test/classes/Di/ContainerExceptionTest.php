<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for PhpMyAdmin\Di\ContainerException class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Di;

use PhpMyAdmin\Di\ContainerException;
use PhpMyAdmin\Tests\PmaTestCase;

/**
 * Tests for PhpMyAdmin\Di\ContainerException class
 *
 * @package PhpMyAdmin-test
 */
class ContainerExceptionTest extends PmaTestCase
{
    /**
     * @access protected
     */
    protected $exception;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->exception = new ContainerException();
    }

    /**
     * Tears down the fixture.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        unset($this->exception);
    }

    /**
     * Test for ContainerException
     */
    public function testContainerExceptionImplementsInteface()
    {
        $this->assertInstanceOf(
            'Psr\Container\ContainerExceptionInterface',
            $this->exception
        );
    }

    /**
     * Test for ContainerException
     */
    public function testContainerExceptionExtendsException()
    {
        $this->assertInstanceOf(
            'Exception',
            $this->exception
        );
    }
}
