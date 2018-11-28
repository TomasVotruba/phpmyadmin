<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * tests for PhpMyAdmin\Properties\Options\OptionsPropertyItem class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Properties\Options;

use PHPUnit\Framework\TestCase;

/**
 * Tests for PhpMyAdmin\Properties\Options\OptionsPropertyItem class
 *
 * @package PhpMyAdmin-test
 */
class OptionsPropertyItemTest extends TestCase
{
    protected $stub;

    /**
     * Configures global environment.
     */
    protected function setUp()
    {
        $this->stub = $this->getMockForAbstractClass('PhpMyAdmin\Properties\Options\OptionsPropertyItem');
    }

    /**
     * tearDown for test cases
     */
    public function tearDown()
    {
        unset($this->stub);
    }

    /**
     * Test for
     *     - PhpMyAdmin\Properties\Options\OptionsPropertyItem::getName
     *     - PhpMyAdmin\Properties\Options\OptionsPropertyItem::setName
     */
    public function testGetSetName()
    {
        $this->stub->setName('name123');

        $this->assertEquals(
            'name123',
            $this->stub->getName()
        );
    }

    /**
     * Test for
     *     - PhpMyAdmin\Properties\Options\OptionsPropertyItem::getText
     *     - PhpMyAdmin\Properties\Options\OptionsPropertyItem::setText
     */
    public function testGetSetText()
    {
        $this->stub->setText('text123');

        $this->assertEquals(
            'text123',
            $this->stub->getText()
        );
    }

    /**
     * Test for
     *     - PhpMyAdmin\Properties\Options\OptionsPropertyItem::getForce
     *     - PhpMyAdmin\Properties\Options\OptionsPropertyItem::setForce
     */
    public function testGetSetForce()
    {
        $this->stub->setForce('force123');

        $this->assertEquals(
            'force123',
            $this->stub->getForce()
        );
    }

    /**
     * Test for PhpMyAdmin\Properties\Options\OptionsPropertyItem::getPropertyType
     */
    public function testGetPropertyType()
    {
        $this->assertEquals(
            'options',
            $this->stub->getPropertyType()
        );
    }
}
