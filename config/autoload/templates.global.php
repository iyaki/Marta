<?php

declare(strict_types=1);

use League\Plates\Extension\Asset;
use League\Plates\Extension\URI;

return [
    'templates' => [
        'paths' => [
            // 'app' => [__DIR__ . '/../../templates/app'],
            'error' => [__DIR__ . '/../../app/Presentation/Common/templates/error'],
            'layout' => [__DIR__ . '/../../app/Presentation/Common/templates/layout'],
            'components' => [__DIR__ . '/../../app/Presentation/Common/templates/components'],
            'cuentas' => [__DIR__ . '/../../app/Presentation/Cuentas/templates'],
        ],
        'extensions' => [
            new Asset(__DIR__ . '/../../public/'),
            // new URI($_SERVER['PATH_INFO']),
        ],
    ],
];
