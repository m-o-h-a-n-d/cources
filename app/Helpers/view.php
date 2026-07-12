<?php

function base_path(string $path = ''): string
{
    return dirname(__DIR__, 2) . ($path ? '/' . $path : '');
}

function view(string $path, array $data = []): void
{
    extract($data);

    require base_path("resources/views/{$path}.php");
}