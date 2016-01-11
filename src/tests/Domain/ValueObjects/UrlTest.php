<?php

namespace Demo\tests\Domain\ValueObjects;

use Demo\Domain\ValueObjects\Url;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Test for Url ValueObject.
 *
 * @package Demo
 *
 * @license Proprietary
 */
class UrlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validUrlProvider
     *
     * @param string $url
     */
    public function testAcceptValidUrls($url)
    {
        $url = new Url($url);

        $this->assertInstanceOf(Url::class, $url);
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $invalidString
     */
    public function testThrowExceptionIfNotStringProvided($invalidString)
    {
        new Url($invalidString);
    }

    /**
     * @dataProvider invalidUrlProvider
     *
     * @expectedException \UnexpectedValueException
     *
     * @param string $invalidUrl
     */
    public function testThrowExceptionOnInvalidUrl($invalidUrl)
    {
        new Url($invalidUrl);
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
     * @dataProvider validUrlProvider
     *
     * @param string $urlString
     */
    public function testCastToString($urlString)
    {
        $url = new Url($urlString);

        $this->assertEquals($url, (string)$url);
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
    public function invalidStringProvider()
    {
        return [
            [123],
            [new stdClass()],
        ];
    }

    /**
     * @return array
     */
    public function invalidUrlProvider()
    {
        return [
            ['http://'],
        ];
    }
}
