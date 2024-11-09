<?php

declare(strict_types=1);

namespace League\Route;

interface RouteCollectionInterface
{
    public function delete(string $path, string|callable $handler): Route;
    public function get(string $path, string|callable $handler): Route;
    public function head(string $path, string|callable $handler): Route;
    public function map(string|array $method, string $path, string|callable $handler): Route;
    public function options(string $path, string|callable $handler): Route;
    public function patch(string $path, string|callable $handler): Route;
    public function post(string $path, string|callable $handler): Route;
    public function put(string $path, string|callable $handler): Route;
}
