<?php
namespace Demo\tests\Domain\Url;

use Demo\Domain\Url\UrlParser;
use Demo\Domain\ValueObjects\Url;
use PHPUnit_Framework_TestCase;

/**
 * Test for UrlParser.
 *
 * @package Demo
 *
 * @license Proprietary
 */
class UrlParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     */
    public function testAcceptValidUrlStrings($urlString)
    {
        new UrlParser($urlString);
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetScheme($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        if (array_key_exists('scheme', $expectedResult)) {
            $this->assertEquals($expectedResult['scheme'], $url->getScheme());
        }
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetHost($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('host', $expectedResult) ? $expectedResult['host'] : null,
            $url->getHost()
        );
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetPort($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('port', $expectedResult) ? $expectedResult['port'] : null,
            $url->getPort()
        );
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetUser($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('user', $expectedResult) ? $expectedResult['user'] : null,
            $url->getUser()
        );
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetPass($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('pass', $expectedResult) ? $expectedResult['pass'] : null,
            $url->getPass()
        );
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetPath($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('path', $expectedResult) ? $expectedResult['path'] : null,
            $url->getPath()
        );
    }

    /**
     * @dataProvider unNormalizedUrlProvider
     *
     * @param \Demo\Domain\ValueObjects\Url $url
     * @param string $expectedPath
     */
    public function testGetPathReturnNormalizedPath($url, $expectedPath)
    {
        $parser = new UrlParser((string)$url);

        $this->assertEquals($expectedPath, $parser->getPath());
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetQuery($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('query', $expectedResult) ? $expectedResult['query'] : null,
            $url->getQuery()
        );
    }

    /**
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     * @param array $expectedResult
     */
    public function testGetFragment($urlString, array $expectedResult)
    {
        $url = new Url($urlString);

        $this->assertEquals(
            array_key_exists('fragment', $expectedResult) ? $expectedResult['fragment'] : null,
            $url->getFragment()
        );
    }

    /**
     * @return array
     */
    public function validUrlProvider()
    {
        return [
            //Scheme and host provided
            ['http://www.google.com', ['scheme' => 'http', 'host' => 'www.google.com']],
            //Full url provided
            [
                'https://username:password@www.google.com:443/path1/path2/index.php'
                . '?getVar1=getValue1&getVar2=getVal2#anchor1',
                [
                    'scheme' => 'https',
                    'host' => 'www.google.com',
                    'port' => 443,
                    'user' => 'username',
                    'pass' => 'password',
                    'path' => '/path1/path2/index.php',
                    'query' => 'getVar1=getValue1&getVar2=getVal2',
                    'fragment' => 'anchor1',
                ],
            ],
            //Url without scheme provided
            ['//www.google.com', ['scheme' => null, 'host' => 'www.google.com']],
        ];
    }

    /**
     * @return array
     */
    public function unNormalizedUrlProvider()
    {
        return [
            [new Url('http://www.google.com'), ''],
            [new Url('http://www.google.com/../'), '/'],
            [new Url('http://www.google.com/.././?query=123'), '/'],
            [new Url('http://www.google.com/path1/path2/index.php'), '/path1/path2/index.php'],
            [new Url('http://www.google.com/path1//path2/index.php'), '/path1/path2/index.php'],
            [new Url('http://www.google.com/path1///path2/index.php'), '/path1/path2/index.php'],
            [new Url('http://www.google.com/path1/../path2/index.php'), '/path2/index.php'],
            [new Url('http://www.google.com/path1/path2/../../index.php'), '/index.php'],
            [new Url('http://www.google.com/path1/path2/../../../index.php'), '/index.php'],
            [new Url('http://www.google.com/./path1/path2/index.php'), '/path1/path2/index.php'],
            [new Url('http://www.google.com/./path1/path2/index.php'), '/path1/path2/index.php'],
            [new Url('http://www.google.com/./././index.php'), '/index.php'],
        ];
    }
}

