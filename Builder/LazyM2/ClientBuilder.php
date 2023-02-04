<?php

declare(strict_types=1);

namespace App\Builder\LazyM2;

use App\Builder\ExampleClasses\Client;
use App\Builder\ExampleClasses\Order;
use Faker\Factory;

final class ClientBuilder
{
    //region constructor arguments
    /** @var Lazy|string */
    private Lazy $name;
    //endregion

    //region public members
    /** @var Lazy|Order[]|null */
    private ?Lazy $orders = null;
    //endregion

    public static function default(): self
    {
        return new self();
    }

    public static function simple(): self
    {
        return self::default()
            ->withName(Factory::create()->name);//            ->withNameCallback(Lazy::create(static fn() => Factory::create()->name))
    }

    public function build(): Client
    {
        $client = new Client($this->name->resolve());

        foreach ($this->orders?->resolve() as $order) {
            $client->addOrder($order);
        }

        return $client;
    }

    public function withOrders(Order ...$order): self
    {
        $this->withOrdersCallback(Lazy::create(static fn () => $order));
        $this->withOrdersCallback2(static fn () => $order);

        return $this;
    }

    public function withOrdersCallback(Lazy $callback): self
    {
        $this->orders = $callback;

        return $this;
    }

    public function withOrdersCallback2(callable $callback): self
    {
        //verify that callback returns array
//        $ref = new \ReflectionClass($callback);

        $this->orders = Lazy::create($callback);

        return $this;
    }

    public function withName(string $name): self
    {
        $this->withNameCallback(static fn () => $name);

        return $this;
    }

    public function withNameCallback(callable $callback): self
    {
        $this->name = Lazy::create($callback);

        return $this;
    }

    public function withNameShort(string|callable $name): self
    {
        if (is_string($name)) {
            $name = static fn (): string => $name;
        }

        //(new \ReflectionFunction($name))->isClosure(); //todo check if correctly checks object with __invoke
//      assert('string' === (string) (new \ReflectionFunction($name))->getReturnType());

        $this->name = Lazy::create($name);

        return $this;
    }
}
