<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Transformers;

use Balpom\Href\Href;
use League\Uri\Uri;

/**
 * Returns froxied URI from string a-la
 * http://web.archive.org/web/20240101000000/http://www.ipmy.ru/
 * http://anonymouse.org/cgi-bin/anon-www.cgi/https://www.ipmy.ru/
 * https://translated.turbopages.org/proxy_u/en-ru.ru/https/www.ipmy.ru/
 * etc...
 */
class GetProxiedUri extends AbstractTransformer
{
    private iterable $tokens;

    public function transform(Href|string $href): Href
    {
        $link = $this->toLink($href);
        $mapping = $this->toMapping($href);
        $mapping = Uri::new($mapping);
        $mapping = $this->getProxiedUri($mapping);

        return (false === $mapping) ? $this->toHref($href) : new Href($link, $mapping);
    }

    protected function getProxiedUri(Uri $uri): string|false
    {
        $string = $this->getStringAfterScheme($uri);
        if (empty($string)) {
            return false;
        }

        $schemes = [
            '/https://' => 'https://',
            '/http://' => 'http://',
            '/https/' => 'https://',
            '/http/' => 'http://',
        ];

        foreach ($schemes as $token => $scheme) {
            if (false !== strpos($string, $token)) {
                $string = strstr($string, $token);
                return $scheme . substr($string, strlen($token));
            }
        }

        return false;
    }

    protected function getStringAfterScheme(Uri $uri): string|false
    {
        $scheme = $uri->getScheme();
        $uri = $uri->toString();
        if (empty($scheme)) {
            return false;
        }
        $scheme .= '://';

        return substr($uri, strlen($scheme));
    }
}
