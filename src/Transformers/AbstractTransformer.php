<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Transformers;

use Balpom\HrefsHandler\HrefTransformerInterface;
use Balpom\Href\Href;
use League\Uri\Uri;
use League\Uri\Components\Fragment;

abstract class AbstractTransformer implements HrefTransformerInterface
{

    abstract public function transform(Href|string $href): Href;

    protected function toHref(Href|string $href): Href
    {
        if (is_object($href)) {
            return $href;
        }
        $href = trim($href);
        if (empty($href)) {
            throw new HrefTransformerException('HREF must be not empty!');
        }

        return new Href($href, $href);
    }

    protected function toLink(Href|string $link): string
    {
        if (!is_string($link)) {
            return $link->link();
        }
        $link = trim($link);
        if (empty($link)) {
            throw new HrefTransformerException('Link must be not empty!');
        }

        return $link;
    }

    protected function toMapping(Href|string $link): string
    {
        if (!is_string($link)) {
            return $link->mapping();
        }
        $link = trim($link);
        if (empty($link)) {
            throw new HrefTransformerException('Mapping link must be not empty!');
        }

        return $link;
    }

    protected function sanitizeUriEnd(string $uri)
    {
        $uri = trim($uri);
        while ('##' === substr($uri, -2)) {
            $uri = substr($uri, 0, -2);
        }
        while ('&&' === substr($uri, -2)) {
            $uri = substr($uri, 0, -2);
        }
        while ('??' === substr($uri, -2)) {
            $uri = substr($uri, 0, -2);
        }
        while ('?#' === substr($uri, -2)) {
            $uri = substr($uri, 0, -2);
        }
        while ('#' === substr($uri, -1)) {
            $uri = substr($uri, 0, -1);
        }
        while ('?&' === substr($uri, -2)) {
            $uri = substr($uri, 0, -2);
        }
        while ('?' === substr($uri, -1)) {
            $uri = substr($uri, 0, -1);
        }

        return $uri;
    }

    protected function removeQuery(string $link, bool $removeFragment = false): string
    {
        $link = trim($link);
        $uri = Uri::new($link)->withQuery('');
        if (!$removeFragment) {
            $fragment = Fragment::fromUri($uri);
            $fragment = $fragment->getUriComponent();
        }
        $uri = $uri->withFragment('')->toString();
        $uri = $this->sanitizeUriEnd($uri);

        if (!$removeFragment) {
            $uri .= $fragment;
        }

        return $uri;
    }

    protected function removeFragment(string $link): string
    {
        $link = trim($link);
        $uri = Uri::new($link)->withFragment('')->toString();
        if ('#' === substr($uri, -1)) {
            $uri = substr($uri, 0, -1);
        }

        return $uri;
    }
}
