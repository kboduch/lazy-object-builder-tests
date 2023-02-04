<?php

declare(strict_types=1);

namespace App\Builder\ExampleClasses;

use Doctrine\Common\Collections\ArrayCollection;

final class Order
{
    /** @var Item[] */
    private readonly iterable $items;

    public function __construct(private readonly Client $client)
    {
        $this->items = new ArrayCollection();
        $this->client->addOrder($this);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getItems(): iterable
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        $this->items->add($item);
    }
}
