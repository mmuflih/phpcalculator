<?php

namespace Jakmall\Recruitment\Calculator\History;

use Illuminate\Contracts\Container\Container;
use Jakmall\Recruitment\Calculator\Container\ContainerServiceProviderInterface;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriver;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriverInterface;

class CommandHistoryServiceProvider implements ContainerServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container): void
    {
        $container->bind(
            HistoryDriverInterface::class,
            function () use ($container) {
                return new HistoryDriver($container);
            }
        );
    }
}
