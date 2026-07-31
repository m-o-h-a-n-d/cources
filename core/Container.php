<?php

namespace Core;

class Container
{
    protected array $bindings = [];

    protected array $instances = [];

    //  abstract => concrete   

    //  abstract :  Interface or class name 

    // concrete :  Class name or closure that returns an instance of the class


    /*

    {
        "studentInterface"=> "studentRepository"
    }

     */
    public function bind(string $abstract,string $concrete): void
        {
        $this->bindings[$abstract] = $concrete;
    }

    public function instance(string $abstract,object $instance): void
    {
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


        $reflection = new \ReflectionClass($concrete); //  تخلي عن اسم الواجهة أو الكلاس وتحويله إلى كلاس يمكن إنشاء نسخة منه

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