<?php
namespace Demo\tests\Domain\Url;

use Demo\Domain\Url\Normalizer;
use Demo\Domain\ValueObjects\Url;
use PHPUnit_Framework_TestCase;

/**
 * Test for Normalizer.
 *
 * @package Demo
 *
 * @license Proprietary
 */
class NormalizerTest extends PHPUnit_Framework_TestCase
{
    public function testAcceptUrlInstance()
    {
        $mockUrl = $this->getMockUrl();

        Normalizer::normalize($mockUrl);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Demo\Domain\ValueObjects\Url
     */
    private function getMockUrl()
    {
        return $this->getMockBuilder(Url::class)->disableOriginalConstructor()->getMock();
    }

    public function testNormalizeReturnsUrlInstance()
    {
        $mockUrl = $this->getMockUrl();

        $this->assertInstanceOf(Url::class, Normalizer::normalize($mockUrl));
    }

    /**
     * @dataProvider urlForNormalizerProvider
     *
     * @param \Demo\Domain\ValueObjects\Url $url
     * @param $expectedResult
     */
    public function testNormalizeCanNormalizeAsExpected(Url $url, $expectedResult)
    {
        $this->assertEquals($expectedResult, (string)Normalizer::normalize($url));
    }

    /**
     * @return array
     */
    public function urlForNormalizerProvider()
    {
        return [
            [new Url('http://www.google.com'), 'http://www.google.com'],
            [new Url('http://www.google.com/../'), 'http://www.google.com/'],
            [new Url('http://www.google.com/.././?query=123'), 'http://www.google.com/?query=123'],
            [new Url('http://www.google.com/path1/path2/index.php'), 'http://www.google.com/path1/path2/index.php'],
            [new Url('http://www.google.com/path1//path2/index.php'), 'http://www.google.com/path1/path2/index.php'],
            [new Url('http://www.google.com/path1///path2/index.php'), 'http://www.google.com/path1/path2/index.php'],
            [new Url('http://www.google.com/path1/../path2/index.php'), 'http://www.google.com/path2/index.php'],
            [new Url('http://www.google.com/path1/path2/../../index.php'), 'http://www.google.com/index.php'],
            [new Url('http://www.google.com/path1/path2/../../../index.php'), 'http://www.google.com/index.php'],
            [new Url('http://www.google.com/./path1/path2/index.php'), 'http://www.google.com/path1/path2/index.php'],
            [new Url('http://www.google.com/./path1/path2/index.php'), 'http://www.google.com/path1/path2/index.php'],
            [new Url('http://www.google.com/./././index.php'), 'http://www.google.com/index.php'],
        ];
    }
}

