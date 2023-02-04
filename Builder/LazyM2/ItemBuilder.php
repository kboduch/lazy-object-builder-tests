<?php

declare(strict_types=1);

namespace App\Builder\LazyM2;

use App\Builder\ExampleClasses\Item;
use Faker\Factory;

final class ItemBuilder
{
    /** @var string */
    private Lazy $name;

    public static function default(): self
    {
        return new self();
    }

    public static function simple(): self
    {
        return self::default()
            ->withName(Factory::create()->name)
            ->withNameCallback(Lazy::create(static fn () => Factory::create()->name));
    }

    public function build(): Item
    {
        return new Item($this->name->resolve());
    }

    public function withName(string $name): self
    {
        $this->withNameCallback(new Lazy(static fn () => $name));

        return $this;
    }

    public function withNameCallback(Lazy $callback): self
    {
        $this->name = $callback;

        return $this;
    }
}
