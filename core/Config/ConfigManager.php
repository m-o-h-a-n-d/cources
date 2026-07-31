<?php

namespace Core\Config;

class ConfigManager
{
   

    public function __construct( protected array $items = [])
    {
        
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        $array = $this->items;

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        

        return $array;
    }

    public function set(string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $array = &$this->items;

        while (count($keys) > 1) {
            $k = array_shift($keys);

            if (!isset($array[$k]) || !is_array($array[$k])) {
                $array[$k] = [];
            }

            $array = &$array[$k];
        }

        $array[array_shift($keys)] = $value;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    public function all(): array
    {
        return $this->items;
    }
}
