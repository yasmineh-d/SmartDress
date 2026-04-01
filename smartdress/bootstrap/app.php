<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    // ÉTAPE IMPORTANTE : On déclare où sont les routes Web et API
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',   // On active le fichier API
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // C'est ici qu'on gérera la sécurité (ex: protection des données du mobile)
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // C'est ici qu'on gère l'affichage des erreurs
    })->create();