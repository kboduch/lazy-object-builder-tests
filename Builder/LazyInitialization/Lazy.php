<?php

declare(strict_types=1);

namespace App\Builder\LazyInitialization;

use Closure;

final class LazyAlt
{
    private bool $isResolved = false;
    private mixed $result;

    public function __construct(private readonly Closure $callback)
    {
    }

    /** @param mixed ...$args callback parameters */
    public function __invoke(mixed ...$args)
    {
        if (!$this->isResolved()) {
            $callback = $this->callback;
            $this->result = $callback(...$args);
            $this->isResolved = true;
        }

        return $this->result;
    }

    public function isResolved(): bool
    {
        return $this->isResolved;
    }
}

final class Lazy
{
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

final class Aggr
{
    public function __construct(public readonly Value $val)
    {
    }
}final class Value
{
    public function __construct(public readonly mixed $val)
    {
    }
}

final class AggrBuilder
{
    private array $arguments = [];

    private Lazy $constructorArgument;
    private ?Lazy $secondArgument = null;

    public static function default(): self
    {
        return new self();
    }

    public static function simple(): self
    {
        return self::default()
            ->withValCallable(new Lazy(static fn () => new Value('from simple e.g. Value Builder')));
    }

    public function build(): Aggr
    {
//        $this->secondArgument?->resolve();
//        isset($this->secondArgument) && $obj->set($this->secondArgument->resolve());

        return new Aggr($this->arguments['val']());
    }

    public function withVal(Value $object): self
    {
        $this->withValCallable(new Lazy(static fn () => $object));

        return $this;
    }

    public function withValCallable(Lazy $callable): self
    {
        $this->arguments['val'] = $callable;
        return $this;
    }
}

//$callback = fn(int $a):null|int|array => [$a];
//
//$ref = new \ReflectionFunction($callback);
//
//$r = $ref->getReturnType();
//$rstri = (string)$r;
//$a = $r->getName();
//assert($rstri === 'array|int|null');
//
//$some = [null];
//
//foreach ($some as $item) {
//    echo 'here';
//}
//
//$aggr = AggrBuilder::simple()->build();
//
//$aggr3 = AggrBuilder::default()->withVal(new Value('from a client code'))->build();
//$aggr2 = AggrBuilder::simple()->withVal(new Value('from a client code'))->build();
//$aggr5 = AggrBuilder::simple()->withValCallable(new Lazy(fn()=> new Value('from a client code')))->build();
//$aggr4 = AggrBuilder::simple()->withValCallable(new Lazy(fn()=> new stdClass('from a client code')))->build();

//exit();
//
//$lazyWithArgs = new Lazy(static function (int $a,string $b, array $c, object $d): int {
//    return 1;
//});
//var_dump($lazyWithArgs);
//
//$lazyWithArgs(4, '5', [6], new \stdClass(7));
////$lazyWithArgs(4, 5, 6);
//
//$empyLazy = new Lazy(static function () {
//    return 'a';
//});
//
//$empyLazy();
