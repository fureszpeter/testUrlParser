<?php

namespace Demo\Domain\Url;

use Demo\Domain\ValueObjects\Url;

/**
 * Normalize an URL.
 *
 * @package Demo
 *
 * @license Proprietary
 */
class Normalizer
{
    /**
     * @param \Demo\Domain\ValueObjects\Url $url
     *
     * @return \Demo\Domain\ValueObjects\Url
     */
    public static function normalize(Url $url)
    {
        $path = $url->getPath();

        //Replace // with /
        $path = preg_replace('%/{2,}%', '/', $path);

        //Replace /./ with /
        $path = preg_replace('%/\./%', '/', $path);

        //Replace /path/../ with /
        $path = preg_replace('%/[^/|\.\.]+/../%', '/', $path);

        //Replace ^/../ with /
        $path = preg_replace('%^/../%', '/', $path);

        if (substr_count($path, '/../') || substr_count($path, '//') || substr_count($path, '/./')) {
            //Call recursively if still need further normalization
            return self::normalize(
                new Url(
                    str_replace($url->getPath(), $path, (string)$url)
                )
            );
        }

        //Otherwise return the normalized path
        return new Url(
            str_replace($url->getPath(), $path, (string)$url)
        );
    }
}
