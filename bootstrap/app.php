<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    //

    $middleware->redirectTo(
      guests: '/login',
      users: '/',
    );

    $middleware->alias([
      'dashboard.roles' => function (Request $request, $next) {

      if($request->user() && !$request->user()->is_active) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->withErrors([
          'email' => 'Tu cuenta esta bloqueada. Contacta con soporte si crees que fue un error.'
        ]);
      }

        $hasPermission = $request->user() && $request->user()->roles()
            ->whereIn('name', ['Administrador', 'Cafeteria', 'Cajero', 'Cocina'])
            ->exists();

        if (!$hasPermission) {
          abort(404, 'Not Found.');
        }
        return $next($request);
      }
    ]);
    })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->shouldRenderJsonWhen(
      fn(Request $request) => $request->is('api/*'),
    );
  })->create();
