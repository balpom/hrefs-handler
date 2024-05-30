<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler\Handlers;

use Balpom\HrefsHandler\HrefsHandlerInterface;
use Balpom\HrefsHandler\TransformersCollectionInterface;
use Balpom\HrefsHandler\TransformersCollection;
use Psr\Link\EvolvableLinkProviderInterface;
use Balpom\Href\HrefCollectionInterface;
use Balpom\Href\HrefCollection;

abstract class AbstractHandler implements HrefsHandlerInterface
{
    protected TransformersCollectionInterface $transformers;

    public function __construct(TransformersCollectionInterface|null $transformers = null)
    {
        if (null !== $transformers) {
            $this->transformers = $transformers;
        } else {
            $this->transformers = new TransformersCollection();
            $this->createTransformers();
        }
    }

    public function handle(EvolvableLinkProviderInterface|HrefCollectionInterface $hrefCollection): HrefCollectionInterface
    {
        if ($hrefCollection instanceof EvolvableLinkProviderInterface) {
            $hrefCollection = new HrefCollection($hrefCollection);
        }
        $hrefs = $hrefCollection->getAll();
        $transformers = $this->transformers->transformers();
        foreach ($hrefs as $href) {
            foreach ($transformers as $transformer) {
                $href = $transformer->transform($href);
            }
            $hrefCollection = $hrefCollection->with($href);
        }

        return $hrefCollection;
    }

    protected function createTransformers(): void
    {

    }
}
