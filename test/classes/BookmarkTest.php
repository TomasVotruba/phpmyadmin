<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for Bookmark class
 *
 * @package PhpMyAdmin-test
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests;

use PhpMyAdmin\Bookmark;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Bookmark class
 *
 * @package PhpMyAdmin-test
 */
class BookmarkTest extends TestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $GLOBALS['cfg']['Server']['user'] = 'root';
        $GLOBALS['cfg']['Server']['pmadb'] = 'phpmyadmin';
        $GLOBALS['cfg']['Server']['bookmarktable'] = 'pma_bookmark';
        $GLOBALS['server'] = 1;
    }

    /**
     * Tests for Bookmark:getParams()
     */
    public function testGetParams()
    {
        $this->assertEquals(
            false,
            Bookmark::getParams($GLOBALS['cfg']['Server']['user'])
        );
    }

    /**
     * Tests for Bookmark::getList()
     */
    public function testGetList()
    {
        $this->assertEquals(
            [],
            Bookmark::getList(
                $GLOBALS['dbi'],
                $GLOBALS['cfg']['Server']['user'],
                'phpmyadmin'
            )
        );
    }

    /**
     * Tests for Bookmark::get()
     */
    public function testGet()
    {
        $this->assertNull(
            Bookmark::get(
                $GLOBALS['dbi'],
                $GLOBALS['cfg']['Server']['user'],
                'phpmyadmin',
                '1'
            )
        );
    }

    /**
     * Tests for Bookmark::save()
     */
    public function testSave()
    {
        $bookmarkData = [
            'bkm_database' => 'phpmyadmin',
            'bkm_user' => 'root',
            'bkm_sql_query' => 'SELECT "phpmyadmin"',
            'bkm_label' => 'bookmark1',
        ];

        $bookmark = Bookmark::createBookmark(
            $GLOBALS['dbi'],
            $GLOBALS['cfg']['Server']['user'],
            $bookmarkData
        );
        $this->assertFalse($bookmark->save());
    }
}
