<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Transformers;

use Balpom\Href\Href;

class RemoveQueryAndFragment extends AbstractTransformer
{

    public function transform(Href|string $href): Href
    {
        $link = $this->toLink($href);
        $mapping = $this->toMapping($href);
        $mapping = $this->removeQuery($mapping, true);

        return new Href($link, $mapping);
    }
}
