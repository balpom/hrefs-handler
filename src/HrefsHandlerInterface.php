<?php

declare(strict_types=1);

namespace Balpom\HrefsHandler;

use Balpom\Href\HrefCollectionInterface;
use Psr\Link\EvolvableLinkProviderInterface;

interface HrefsHandlerInterface
{

    public function handle(EvolvableLinkProviderInterface|HrefCollectionInterface $hrefCollection): HrefCollectionInterface;
}
