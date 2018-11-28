<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * tests for PhpMyAdmin\Properties\Plugins\ExportPluginProperties class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Properties\Plugins;

use PhpMyAdmin\Properties\Plugins\ExportPluginProperties;

/**
 * Tests for PhpMyAdmin\Properties\Plugins\ExportPluginProperties class. Extends PMA_ImportPluginProperties_Tests
 * and adds tests for methods that are not common to both
 *
 * @package PhpMyAdmin-test
 */
class ExportPluginPropertiesTest extends ImportPluginPropertiesTest
{
    protected $object;

    /**
     * Configures global environment.
     */
    protected function setUp()
    {
        $this->object = new ExportPluginProperties();
    }

    /**
     * tearDown for test cases
     */
    public function tearDown()
    {
        unset($this->object);
    }

    /**
     * Test for PhpMyAdmin\Properties\Plugins\ExportPluginProperties::getItemType
     */
    public function testGetItemType()
    {
        $this->assertEquals(
            'export',
            $this->object->getItemType()
        );
    }

    /**
     * Test for
     *     - PhpMyAdmin\Properties\Plugins\ExportPluginProperties::getForceFile
     *     - PhpMyAdmin\Properties\Plugins\ExportPluginProperties::setForceFile
     */
    public function testSetGetForceFile()
    {
        $this->object->setForceFile(true);

        $this->assertTrue(
            $this->object->getForceFile()
        );
    }
}
