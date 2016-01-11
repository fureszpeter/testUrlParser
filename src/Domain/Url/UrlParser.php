<?php
namespace Demo\Domain\Url;

use Demo\Domain\ValueObjects\Url;
use Demo\Infrastructure\Validation\TypeChecker;

/**
 * Class UrlParser.
 *
 * @package Demo
 *
 * @license Proprietary
 */
class UrlParser
{
    /**
     * @var \Demo\Domain\ValueObjects\Url
     */
    private $url;

    /**
     * UrlParser constructor.
     *
     * @param string $urlString
     *
     * @throws \InvalidArgumentException If argument is not a string.
     */
    public function __construct($urlString)
    {
        TypeChecker::assertString($urlString, '$urlString');

        $this->url = Normalizer::normalize(new Url($urlString));
    }

    /**
     * @return null|string
     */
    public function getScheme()
    {
        return $this->url->getScheme();
    }

    /**
     * @return null|string
     */
    public function getHost()
    {
        return $this->url->getHost();
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        return $this->url->getPort();
    }

    /**
     * @return null|string
     */
    public function getUser()
    {
        return $this->url->getUser();
    }

    /**
     * @return null|string
     */
    public function getPass()
    {
        return $this->url->getPass();
    }

    /**
     * @return null|string
     */
    public function getPath()
    {
        return $this->url->getPath();
    }

    /**
     * @return null|string
     */
    public function getQuery()
    {
        return $this->url->getQuery();
    }

    /**
     * @return null|string
     */
    public function getFragment()
    {
        return $this->url->getFragment();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->url;
    }
}
