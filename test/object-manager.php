<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;

require __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../config/container.php';

return $container->get(EntityManagerInterface::class);
