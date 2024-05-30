<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Transformers;

use Balpom\Href\Href;

class NotChangingTransformer extends AbstractTransformer
{

    public function transform(Href|string $href): Href
    {
        return $this->toHref($href);
    }
}
