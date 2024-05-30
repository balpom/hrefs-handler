<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler;

class TransformersCollection implements TransformersCollectionInterface
{
    private array $transformers = [];

    public function add(HrefTransformerInterface $transformer): void
    {
        $this->transformers[] = $transformer;
    }

    public function transformers(): array
    {
        return $this->transformers;
    }
}
