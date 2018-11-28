<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * tests for PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Properties\Options\Groups;

use PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup;
use PHPUnit\Framework\TestCase;

/**
 * tests for PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup class
 *
 * @package PhpMyAdmin-test
 */
class OptionsPropertyRootGroupTest extends TestCase
{
    protected $object;

    /**
     * Configures global environment.
     */
    protected function setUp()
    {
        $this->object = new OptionsPropertyRootGroup();
    }

    /**
     * tearDown for test cases
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * Test for PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup::getItemType
     */
    public function testGetItemType()
    {
        $this->assertEquals(
            'root',
            $this->object->getItemType()
        );
    }

    /**
     * Test for contable interface
     */
    public function testCountable()
    {
        $this->assertCount(
            0,
            $this->object
        );
    }
}
