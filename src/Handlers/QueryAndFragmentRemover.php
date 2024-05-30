<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Handlers;

use Balpom\HrefsHandler\Transformers\RemoveQueryAndFragment;

class QueryAndFragmentRemover extends AbstractHandler
{

    protected function createTransformers(): void
    {
        $this->transformers->add(new RemoveQueryAndFragment());
    }
}
