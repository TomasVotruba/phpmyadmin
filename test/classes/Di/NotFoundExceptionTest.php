<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for PhpMyAdmin\Di\NotFoundException class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Di;

use PhpMyAdmin\Di\NotFoundException;
use PhpMyAdmin\Tests\PmaTestCase;

/**
 * Tests for PhpMyAdmin\Di\NotFoundException class
 *
 * @package PhpMyAdmin-test
 */
class NotFoundExceptionTest extends PmaTestCase
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
        $this->exception = new NotFoundException();
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
     * Test for NotFoundException
     */
    public function testNotFoundExceptionImplementsInteface()
    {
        $this->assertInstanceOf(
            'Psr\Container\NotFoundExceptionInterface',
            $this->exception
        );
    }

    /**
     * Test for NotFoundException
     */
    public function testNotFoundExceptionExtendsContainerExceptionInteface()
    {
        $this->assertInstanceOf(
            'Psr\Container\ContainerExceptionInterface',
            $this->exception
        );
    }

    /**
     * Test for NotFoundException
     */
    public function testContainerExceptionExtendsException()
    {
        $this->assertInstanceOf(
            'Exception',
            $this->exception
        );
    }
}
