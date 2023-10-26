<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && ($_SERVER['SCRIPT_FILENAME'] ?? null) !== __FILE__) {
    return false;
}

// chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
 */
(function (): void {
    $container = require __DIR__ . '/../config/container.php';

    $app = $container->get(\Mezzio\Application::class);
    // $factory = $container->get(\Mezzio\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require __DIR__ . '/../config/pipeline.php')($app, $container/* , $factory */);
    (require __DIR__ . '/../config/routes.php')($app,  $container/* , $factory */);

    $app->run();
})();
