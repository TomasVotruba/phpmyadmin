<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * tests for PhpMyAdmin\Properties\PropertyItem class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Properties;

use PHPUnit\Framework\TestCase;

/**
 * Tests for PhpMyAdmin\Properties\PropertyItem class
 *
 * @package PhpMyAdmin-test
 */
class PropertyItemTest extends TestCase
{
    protected $stub;

    /**
     * Configures global environment.
     */
    protected function setUp()
    {
        $this->stub = $this->getMockForAbstractClass('PhpMyAdmin\Properties\PropertyItem');
    }

    /**
     * tearDown for test cases
     */
    public function tearDown()
    {
        unset($this->stub);
    }

    /**
     * Test for PhpMyAdmin\Properties\PropertyItem::getGroup
     */
    public function testGetGroup()
    {
        $this->assertEquals(
            null,
            $this->stub->getGroup()
        );
    }
}
