<?php

namespace Core;

class Container
{
    protected array $bindings = [];

    protected array $instances = [];

    public function bind(
        string $abstract,
        string $concrete
    ): void {
        $this->bindings[$abstract] = $concrete;
    }

    public function instance(
        string $abstract,
        object $instance
    ): void {
        $this->instances[$abstract] = $instance;
    }

    public function make(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
        } else {
            $concrete = $abstract;
        }

        $reflection = new \ReflectionClass($concrete);

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $concrete();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {

            $type = $parameter->getType();

            if (! $type instanceof \ReflectionNamedType) {
                throw new \RuntimeException(
                    "Cannot resolve dependency"
                );
            }

            $dependencies[] = $this->make(
                $type->getName()
            );
        }

        return $reflection->newInstanceArgs(
            $dependencies
        );
    }
}