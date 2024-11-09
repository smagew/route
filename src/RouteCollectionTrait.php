<?php

declare(strict_types=1);

namespace League\Route;

use League\Route\Http\Request;

trait RouteCollectionTrait
{
    abstract public function map(string|array $method, string $path, string|callable $handler): Route;

    public function delete(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_DELETE, $path, $handler);
    }

    public function get(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_GET, $path, $handler);
    }

    public function head(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_HEAD, $path, $handler);
    }

    public function options(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_OPTIONS, $path, $handler);
    }

    public function patch(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_PATCH, $path, $handler);
    }

    public function post(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_POST, $path, $handler);
    }

    public function put(string $path, string|callable $handler): Route
    {
        return $this->map(Request::METHOD_PUT, $path, $handler);
    }
}
