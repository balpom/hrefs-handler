<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler;

use Balpom\Href\Href;

interface HrefTransformerInterface
{

    /**
     * Modify mapping from Href object and return new Href object with modified mapping.
     * If $href is string - assumes, what mapping is equal $href, modify it and return
     * new Href object with modified mapping.
     */
    public function transform(Href|string $href): Href;
}
