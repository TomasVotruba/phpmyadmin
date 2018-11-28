<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Selenium TestCase for SQL query window related tests
 *
 * @package    PhpMyAdmin-test
 * @subpackage Selenium
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests\Selenium;

/**
 * XssTest class
 *
 * @package    PhpMyAdmin-test
 * @subpackage Selenium
 * @group      selenium
 */
class XssTest extends TestBase
{
    public function setUp()
    {
        parent::setUp();
        $this->maximize();
        $this->login();
    }

    /**
     * Tests the SQL query tab with a null query
     *
     * @group large
     */
    public function testQueryTabWithNullValue()
    {
        if ($this->isSafari()) {
            $this->markTestSkipped('Alerts not supported on Safari browser.');
        }
        $this->waitForElement('partialLinkText', "SQL")->click();
        $this->waitAjax();

        $this->waitForElement('id', "queryboxf");
        $this->byId("button_submit_query")->click();
        $this->assertEquals("Missing value in the form!", $this->alertText());
    }
}
