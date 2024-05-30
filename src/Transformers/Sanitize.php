<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Transformers;

use Balpom\Href\Href;
use League\Uri\Uri;
use League\Uri\Components\Query;

class Sanitize extends AbstractTransformer
{

    public function transform(Href|string $href): Href
    {
        $link = $this->toLink($href);
        $mapping = $this->toMapping($href);
        $query = Query::fromUri($mapping)->withoutEmptyPairs();
        $mapping = Uri::new($mapping)->withQuery($query)->toString();
        $mapping = $this->sanitizeUriEnd($mapping);

        return new Href($link, $mapping);
    }
}
