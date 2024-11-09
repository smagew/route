<?php

declare(strict_types=1);

namespace League\Route\Http\Response;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class DecoratorTest extends TestCase
{
    public function testDecoratesWithDefaultHeaders(): void
    {
        $decorator = new Decorator\DefaultHeaderDecorator([
            'content-type' => 'application/json',
            'custom-key' => 'custom value',
        ]);

        $response = $this->createMock(ResponseInterface::class);

        $response
            ->expects($this->exactly(2))
            ->method('hasHeader')
            ->willReturnCallback(function (string $header) {
                return $header !== 'content-type';
            })
        ;

        $response
            ->expects($this->once())
            ->method('withAddedHeader')
            ->with($this->equalTo('content-type'), $this->equalTo('application/json'))
            ->willReturnSelf()
        ;

        $decorator($response);
    }
}
