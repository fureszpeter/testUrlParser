<?php

namespace Demo\Domain\ValueObjects;

use Demo\Infrastructure\Validation\TypeChecker;
use UnexpectedValueException;

/**
 * Represent an URL ValueObject.
 *
 * @license Proprietary
 */
class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string|null
     */
    private $scheme;

    /**
     * @var string|null
     */
    private $host;

    /**
     * @var int|null
     */
    private $port;

    /**
     * @var string|null
     */
    private $user;

    /**
     * @var string|null
     */
    private $pass;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var string|null
     */
    private $query;

    /**
     * @var string|null
     */
    private $fragment;

    /**
     * @param string $url
     *
     * @throws \InvalidArgumentException If $urlString is not a string
     * @throws \UnexpectedValueException If provided string is not a valid URL
     */
    public function __construct($url)
    {
        TypeChecker::assertString($url, '$url');

        $components = parse_url($url);

        if (! $components) {
            throw new UnexpectedValueException(
                sprintf('Provided URL is invalid. [Received: %s]', $url)
            );
        }

        $this->url = $url;

        $this->scheme = array_key_exists('scheme', $components) ? $components['scheme'] : null;
        $this->host = array_key_exists('host', $components) ? $components['host'] : null;
        $this->port = array_key_exists('port', $components) ? $components['port'] : null;
        $this->user = array_key_exists('user', $components) ? $components['user'] : null;
        $this->pass = array_key_exists('pass', $components) ? $components['pass'] : null;
        $this->path = array_key_exists('path', $components) ? $components['path'] : null;
        $this->path = array_key_exists('path', $components) ? $components['path'] : null;
        $this->query = array_key_exists('query', $components) ? $components['query'] : null;
        $this->fragment = array_key_exists('fragment', $components) ? $components['fragment'] : null;
    }

    /**
     * @return string|null
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @return null|string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return null|string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return null|string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return null|string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return null|string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->url;
    }
}
