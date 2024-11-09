<?php

declare(strict_types=1);

namespace League\Route;

use PHPUnit\Framework\TestCase;

class RouteGroupTest extends TestCase
{
    public function testGroupIsInvokedAndAddsRoutesToCollection(): void
    {
        $callback = static function () {
        };

        $router = $this->createMock(Router::class);
        $route  = $this->createMock(Route::class);

        $route
            ->expects($this->exactly(8))
            ->method('setHost')
            ->with($this->equalTo('example.com'))
            ->willReturnSelf()
        ;

        $route
            ->expects($this->exactly(8))
            ->method('setScheme')
            ->with($this->equalTo('https'))
            ->willReturnSelf()
        ;

        $route
            ->expects($this->exactly(8))
            ->method('setPort')
            ->with($this->equalTo(8080))
            ->willReturnSelf()
        ;

        $router
            ->expects($this->exactly(7))
            ->method('map')
            ->with(
                $this->matchesRegularExpression('/^(GET|POST|PUT|PATCH|DELETE|OPTIONS|HEAD)$/'),
                $this->equalTo('/acme/route'),
                $this->equalTo($callback)
            )
            ->willReturn($route)
        ;


        $group = new RouteGroup('/acme', function ($route) use ($callback) {
            $route->get('/route', $callback)
                ->setHost('example.com')->setPort(8080)->setScheme('https');
            $route->post('/route', $callback);
            $route->put('/route', $callback);
            $route->patch('/route', $callback);
            $route->delete('/route', $callback);
            $route->options('/route', $callback);
            $route->head('/route', $callback);
        }, $router);

        $group
            ->setHost('example.com')
            ->setScheme('https')
            ->setPort(8080)
        ;

        $group();
    }

    public function testGroupAddsStrategyToRoute(): void
    {
        $callback = static function () {
        };

        $router   = $this->createMock(RouteCollectionInterface::class);
        $strategy = $this->createMock(Strategy\JsonStrategy::class);
        $route    = $this->createMock(Route::class);

        $router
            ->expects($this->once())
            ->method('map')
            ->with($this->equalTo('GET'), $this->equalTo('/acme/route'), $this->equalTo($callback))
            ->willReturn($route)
        ;

        $route
            ->expects($this->once())
            ->method('setStrategy')
            ->with($this->equalTo($strategy))
            ->willReturnSelf()
        ;

        $group = new RouteGroup('/acme', function ($route) use ($callback) {
            $route->get('/route', $callback);
        }, $router);

        $group->setStrategy($strategy);

        $group();
    }

    public function testGroupWithNamedRoutes(): void
    {
        $router = new Router();
        $name   = 'route';
        $expected = null;

        $router->group('/acme', function (RouteGroup $group) use ($name, &$expected) {
            $expected = $group->get('/route', function () {
            })
            ->setName($name);
        });

        $actual = $router->getNamedRoute($name);

        $this->assertNotNull($actual);
        $this->assertSame($expected, $actual);
    }
}
