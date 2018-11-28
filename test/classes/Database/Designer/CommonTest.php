<?php
/**
 * Tests for PhpMyAdmin\Database\Designer\Common
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Database\Designer;

use PhpMyAdmin\Database\Designer\Common;
use PhpMyAdmin\DatabaseInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for PhpMyAdmin\Database\Designer\Common
 *
 * @package PhpMyAdmin-test
 */
class CommonTest extends TestCase
{
    /**
     * @var Common
     */
    private $designerCommon;

    /**
     * Setup for test cases
     */
    protected function setUp()
    {
        $GLOBALS['server'] = 1;
        $_SESSION = [
            'relation' => [
                '1' => [
                    'PMA_VERSION' => PMA_VERSION,
                    'db' => 'pmadb',
                    'pdf_pages' => 'pdf_pages',
                    'pdfwork' => true,
                    'table_coords' => 'table_coords',
                ],
            ],
        ];
    }

    /**
     * Test for getTablePositions()
     */
    public function testGetTablePositions()
    {
        $pg = 1;

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with(
                "
            SELECT CONCAT_WS('.', `db_name`, `table_name`) AS `name`,
                `x` AS `X`,
                `y` AS `Y`,
                1 AS `V`,
                1 AS `H`
            FROM `pmadb`.`table_coords`
            WHERE pdf_page_number = " . $pg,
                'name',
                null,
                DatabaseInterface::CONNECT_CONTROL,
                DatabaseInterface::QUERY_STORE
            );
        $GLOBALS['dbi'] = $dbi;

        $this->designerCommon = new Common($GLOBALS['dbi']);

        $this->designerCommon->getTablePositions($pg);
    }

    /**
     * Test for getPageName()
     */
    public function testGetPageName()
    {
        $pg = 1;
        $pageName = 'pageName';

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with(
                "SELECT `page_descr` FROM `pmadb`.`pdf_pages`"
                . " WHERE `page_nr` = " . $pg,
                null,
                null,
                DatabaseInterface::CONNECT_CONTROL,
                DatabaseInterface::QUERY_STORE
            )
            ->will($this->returnValue([$pageName]));
        $GLOBALS['dbi'] = $dbi;

        $this->designerCommon = new Common($GLOBALS['dbi']);

        $result = $this->designerCommon->getPageName($pg);

        $this->assertEquals($pageName, $result);
    }

    /**
     * Test for deletePage()
     */
    public function testDeletePage()
    {
        $pg = 1;

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $dbi->expects($this->exactly(2))
            ->method('query')
            ->willReturnOnConsecutiveCalls(
                true,
                true
            );
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $this->designerCommon = new Common($GLOBALS['dbi']);

        $result = $this->designerCommon->deletePage($pg);
        $this->assertEquals(true, $result);
    }

    /**
     * Test for testGetDefaultPage() when there is a default page
     * (a page having the same name as database)
     */
    public function testGetDefaultPage()
    {
        $db = 'db';
        $default_pg = '2';

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with(
                "SELECT `page_nr` FROM `pmadb`.`pdf_pages`"
                . " WHERE `db_name` = '" . $db . "'"
                . " AND `page_descr` = '" . $db . "'",
                null,
                null,
                DatabaseInterface::CONNECT_CONTROL,
                DatabaseInterface::QUERY_STORE
            )
            ->will($this->returnValue([$default_pg]));
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $this->designerCommon = new Common($GLOBALS['dbi']);

        $result = $this->designerCommon->getDefaultPage($db);
        $this->assertEquals($default_pg, $result);
    }

    /**
     * Test for testGetDefaultPage() when there is no default page
     */
    public function testGetDefaultPageWithNoDefaultPage()
    {
        $db = 'db';

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with(
                "SELECT `page_nr` FROM `pmadb`.`pdf_pages`"
                . " WHERE `db_name` = '" . $db . "'"
                . " AND `page_descr` = '" . $db . "'",
                null,
                null,
                DatabaseInterface::CONNECT_CONTROL,
                DatabaseInterface::QUERY_STORE
            )
            ->will($this->returnValue([]));
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $this->designerCommon = new Common($GLOBALS['dbi']);

        $result = $this->designerCommon->getDefaultPage($db);
        $this->assertEquals(-1, $result);
    }

    /**
     * Test for testGetLoadingPage() when there is a default page
     */
    public function testGetLoadingPageWithDefaultPage()
    {
        $db = 'db';
        $default_pg = '2';

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with(
                "SELECT `page_nr` FROM `pmadb`.`pdf_pages`"
                . " WHERE `db_name` = '" . $db . "'"
                . " AND `page_descr` = '" . $db . "'",
                null,
                null,
                DatabaseInterface::CONNECT_CONTROL,
                DatabaseInterface::QUERY_STORE
            )
            ->will($this->returnValue([$default_pg]));
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $this->designerCommon = new Common($GLOBALS['dbi']);

        $result = $this->designerCommon->getLoadingPage($db);
        $this->assertEquals($default_pg, $result);
    }

    /**
     * Test for testGetLoadingPage() when there is no default page
     */
    public function testGetLoadingPageWithNoDefaultPage()
    {
        $db = 'db';
        $first_pg = '1';

        $dbi = $this->getMockBuilder('PhpMyAdmin\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $dbi->expects($this->exactly(2))
            ->method('fetchResult')
            ->willReturnOnConsecutiveCalls(
                [],
                [[$first_pg]]
            );
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $this->designerCommon = new Common($GLOBALS['dbi']);

        $result = $this->designerCommon->getLoadingPage($db);
        $this->assertEquals($first_pg, $result);
    }
}
