<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Handlers;

use Balpom\HrefsHandler\Transformers\RemoveFragment;

class FragmentRemover extends AbstractHandler
{

    protected function createTransformers(): void
    {
        $this->transformers->add(new RemoveFragment());
    }
}
