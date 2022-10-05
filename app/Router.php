<?php

namespace App;

use App\Attributes\Route;
use App\Enums\HttpMethod;
use App\Contracts\{ControllerInterface, RouteInterface};
use App\Exceptions\RouteNotFoundException;
use Illuminate\Container\Container;
use Psr\Container\{ContainerExceptionInterface, NotFoundExceptionInterface};
use ReflectionException;

class Router
{
    private array $routes = [];

    public function __construct(private readonly Container $container)
    {
    }

    /**
     * @throws ReflectionException
     */
    public function registerFromControllerAttributes(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);
            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    /** @var RouteInterface $route */
                    $route = $attribute->newInstance();
                    $this->register($route->method, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
    }

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register(HttpMethod::GET, $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register(HttpMethod::POST, $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @throws RouteNotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);
            if (!$class instanceof ControllerInterface) {
                throw new RouteNotFoundException();
            }

            $class->beforeAction();

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }
}
