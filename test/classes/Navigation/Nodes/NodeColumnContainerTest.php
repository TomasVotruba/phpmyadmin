<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for PhpMyAdmin\Navigation\Nodes\NodeColumnContainer class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Navigation\Nodes;

use PhpMyAdmin\Navigation\NodeFactory;
use PhpMyAdmin\Tests\PmaTestCase;

/**
 * Tests for PhpMyAdmin\Navigation\Nodes\NodeColumnContainer class
 *
 * @package PhpMyAdmin-test
 */
class NodeColumnContainerTest extends PmaTestCase
{
    /**
     * SetUp for test cases
     */
    protected function setUp()
    {
        $GLOBALS['server'] = 0;
    }

    /**
     * Test for PhpMyAdmin\Navigation\NodeFactory::__construct
     */
    public function testConstructor()
    {
        $parent = NodeFactory::getInstance('NodeColumnContainer');
        $this->assertArrayHasKey(
            'text',
            $parent->links
        );
        $this->assertContains(
            'tbl_structure.php',
            $parent->links['text']
        );
        $this->assertEquals('columns', $parent->real_name);
    }
}
