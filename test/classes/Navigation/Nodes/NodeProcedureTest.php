<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for PhpMyAdmin\Navigation\Nodes\NodeProcedure class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Navigation\Nodes;

use PhpMyAdmin\Navigation\NodeFactory;
use PhpMyAdmin\Tests\PmaTestCase;

/**
 * Tests for PhpMyAdmin\Navigation\Nodes\NodeProcedure class
 *
 * @package PhpMyAdmin-test
 */
class NodeProcedureTest extends PmaTestCase
{
    /**
     * SetUp for test cases
     */
    protected function setUp()
    {
        $GLOBALS['server'] = 0;
    }

    /**
     * Test for __construct
     */
    public function testConstructor()
    {
        $parent = NodeFactory::getInstance('NodeProcedure');
        $this->assertArrayHasKey(
            'text',
            $parent->links
        );
        $this->assertContains(
            'db_routines.php',
            $parent->links['text']
        );
    }
}
