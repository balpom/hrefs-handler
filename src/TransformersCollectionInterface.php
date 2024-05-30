<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler;

interface TransformersCollectionInterface
{

    public function add(HrefTransformerInterface $transformer): void;

    public function transformers(): iterable;
}
