<?php
/**
 * Tests for PhpMyAdmin\FileListing
 * @package PhpMyAdmin\Tests
 */

namespace PhpMyAdmin\Tests;

use PhpMyAdmin\FileListing;
use PHPUnit\Framework\TestCase;

/**
 * Class FileListingTest
 * @package PhpMyAdmin\Tests
 */
class FileListingTest extends TestCase
{
    /**
     * @var FileListing
     */
    private $fileListing;
    
    protected function setUp(): void
    {
        $this->fileListing = new FileListing();
    }
    
    public function testGetDirContent(): void
    {
        $this->assertFalse($this->fileListing->getDirContent('nonexistent directory'));
    }
    
    public function testGetFileSelectOptions(): void
    {
        $this->assertFalse($this->fileListing->getFileSelectOptions('nonexistent directory'));
    }
    
    public function testSupportedDecompressions(): void
    {
        $GLOBALS['cfg']['ZipDump'] = false;
        $GLOBALS['cfg']['GZipDump'] = false;
        $GLOBALS['cfg']['BZipDump'] = false;
        $this->assertEmpty($this->fileListing->supportedDecompressions());

        $GLOBALS['cfg']['ZipDump'] = true;
        $GLOBALS['cfg']['GZipDump'] = true;
        $GLOBALS['cfg']['BZipDump'] = true;
        $this->assertEquals('gz|bz2|zip', $this->fileListing->supportedDecompressions());
    }
}
