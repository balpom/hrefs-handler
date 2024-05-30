<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Transformers;

use Balpom\Href\Href;
use League\Uri\Uri;
use League\Uri\Components\Query;
use League\Uri\Components\Fragment;

class RemoveFromQuery extends AbstractTransformer
{
    private iterable|null $tokens;

    public function __construct(iterable|string|null $tokens = null)
    {
        if (is_string($tokens)) {
            $tokens = [$tokens];
        }
        $this->tokens = $tokens;
    }

    public function transform(Href|string $href): Href
    {
        if (empty($this->tokens)) {
            return $this->toHref($href);
        }

        $link = $this->toLink($href);
        $mapping = $this->toMapping($href);

        $query = Query::fromUri($mapping);
        if (empty((string) $query)) {
            return $this->toHref($href);
        }

        $filteredQuery = $this->removeTokensFromQuery($query);
        if ($query->count() === $filteredQuery->count()) {
            return $this->toHref($href);
        }

        $fragment = Fragment::fromUri($mapping)->getUriComponent();

        $mapping = Uri::new($mapping)->toString();
        $mapping = $this->removeQuery($mapping, true);

        $query = $filteredQuery->getUriComponent();
        $query = $this->sanitizeUriEnd($query);

        $mapping .= $query . $fragment;

        return new Href($link, $mapping);
    }

    protected function removeTokensFromQuery(Query $query): Query
    {
        foreach ($this->tokens as $token) {
            $query = $query->withoutPairByKey($token);
        }

        return $query;
    }
}
