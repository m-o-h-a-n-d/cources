<?php

namespace Core\Config;

class ConfigLoader
{
    public function load(string $configPath): array
    {
        $items = [];

        if (!is_dir($configPath)) {
            return $items;
        }

        $files = glob(rtrim($configPath, '/\\') . '/*.php');

        if ($files === false) {
            return $items;
        }

        foreach ($files as $file) {
            $key = pathinfo($file, PATHINFO_FILENAME);
            $data = require $file;

            if (is_array($data)) {
                $items[$key] = $data;
            }
        }

        return $items;
    }
}
