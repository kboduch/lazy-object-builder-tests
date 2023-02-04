<?php

declare(strict_types=1);

namespace App\Builder\ExampleClasses;

use Doctrine\Common\Collections\ArrayCollection;

final class Client
{
    /** @var Order[] */
    private readonly iterable $orders;

    public function __construct(private readonly string $name)
    {
        $this->orders = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addOrder(Order $order): void
    {
        !$this->orders->contains($order) && $this->orders->add($order);
    }
}
