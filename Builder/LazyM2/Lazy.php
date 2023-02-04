<?php

declare(strict_types=1);

namespace App\Builder\LazyM2;

use Closure;

final class Lazy
{
    public static function create(Closure $callback): self
    {
        return new self($callback);
    }

    public function __construct(private readonly Closure $callback)
    {
    }

    /** @param mixed ...$args callback parameters */
    public function resolve(mixed ...$args)
    {
        $callback = $this->callback;

        return $callback(...$args);
    }
}
