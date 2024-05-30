<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Handlers;

use Balpom\HrefsHandler\Transformers\Sanitize;

class Sanitizer extends AbstractHandler
{

    protected function createTransformers(): void
    {
        $this->transformers->add(new Sanitize());
    }
}
