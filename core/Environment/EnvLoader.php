<?php

namespace Core\Environment;

class EnvLoader
{
    public function load(string $filePath): void
    {
        if (! file_exists($filePath)) {
            throw new \RuntimeException(
                "Environment file not found: $filePath"
            );
        }

        $lines = file(
            $filePath,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES 
        );

        foreach ($lines as $line) {

            $line = trim($line);

            // Skip empty lines and comments
            if (
                $line === '' ||
                str_starts_with($line, '#')
            ) {
                continue;
            }

            $parts = explode('=', $line, 2);

            // Invalid environment variable
            if (count($parts) !== 2) {
                continue;
            }

            [$key, $value] = $parts;

            $key = trim($key);
            $value = trim($value);

            // Remove surrounding quotes
            $value = trim($value, "\"'");

            $_ENV[$key] = $value;
        }
    }
}
