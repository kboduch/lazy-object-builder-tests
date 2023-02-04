<?php

declare(strict_types=1);

namespace App\Builder\ExampleClasses;

final class Item
{
    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
