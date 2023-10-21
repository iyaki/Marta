<?php

declare(strict_types=1);

use Marta\Presentation\Cuentas\Controllers\CuentasCrearHandler;
use Marta\Presentation\Cuentas\Controllers\CuentasIndiceHandler;
use Marta\Presentation\Cuentas\Controllers\CuentasNuevoHandler;
use Marta\Presentation\Cuentas\Controllers\CuentasActualizarHandler;
use Marta\Presentation\Cuentas\Controllers\CuentasEdicionHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Marta\Cuentas\WebMarta\GetCuentasViewHandler;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', Marta\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', Marta\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', Marta\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', Marta\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', Marta\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', Marta\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', Marta\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     Marta\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (Application $app, /* MiddlewareFactory $factory, ContainerInterface $container */): void {
    /**
     * Routes follow the RAILS standard for resources
     * https://guides.rubyonrails.org/routing.html#crud-verbs-and-actions
     * https://edgeapi.rubyonrails.org/classes/ActionDispatch/Routing/Mapper/Resources.html#method-i-resources
     *
     * GET          /photos                INDICE
     * GET          /photos/nuevo          NUEVO
     * POST         /photos                CREAR
     * GET          /photos/:id            MOSTRAR - Es realmente necesario este endpoint? Se va a usar alguna vez?
     * GET          /photos/:id/edicion    EDICION
     * PATCH/PUT    /photos/:id            ACTUALIZAR
     * DELETE       /photos/:id            DESTRUIR
    */

    /**
     * TODO: Mover las rutas y nombres (o por lo menos los nombres) a constantes
     * o algo asi para evitar typos en las vistas
     *
     * TODO: Crear función que agregue todos los endpoints para un recurso
     * "a la vez", según convenciones
     *
     * TODO: Crear un Handler para implemntar Controllers que tengan todos los
     * metodos de los endpoints CRUD en una sola clase???
     */
    $app->get('/cuentas', CuentasIndiceHandler::class, 'cuentas.indice');
    $app->get('/cuentas/nuevo', CuentasNuevoHandler::class, 'cuentas.nuevo');
    $app->post('/cuentas', CuentasCrearHandler::class, 'cuentas.crear');
    $app->get('/cuentas/{id:\d+}/edicion', CuentasEdicionHandler::class, 'cuentas.edicion');
    // TODO: Convertir este POST en un PUT
    $app->post('/cuentas/{id:\d+}', CuentasActualizarHandler::class, 'cuentas.actualizar');
};
