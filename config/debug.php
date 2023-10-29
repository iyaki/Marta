<?php

use Clockwork\Support\Vanilla\Clockwork;
use Psr\Container\ContainerInterface;


return function (ContainerInterface $container): void {
    if (
        ! ($container->get('config')['debug'] ?? false)
        && class_exists(Clockwork::class)
    ) {
        return;
    }
    Clockwork::init([
        'register_helpers' => true,
    ]);
};
