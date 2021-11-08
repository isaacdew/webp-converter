<?php declare(strict_types=1);

use Isaacdew\WebPConverter\WebPConverter;
use PHPUnit\Framework\TestCase;

/**
 * @covers WebPConverter
 */
class WebPConverterTest extends TestCase {
    public function testFileConversion() {
        $file = dirname(__DIR__) . '/stubs/screenshot.png';
        $convert = WebPConverter::convert($file);

        $this->assertFileExists($convert->getDestination());
    }

    protected function tearDown():void {
        unlink(dirname(__DIR__) . '/stubs/screenshot.webp');
    }
}