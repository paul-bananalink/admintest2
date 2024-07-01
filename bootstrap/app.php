<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \App\Http\Middleware\RouteDetectMiddleware;
use \App\Http\Middleware\BlockIPMiddleware;
use \App\Http\Middleware\TrackUserActivity;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        channels: __DIR__ . '/../routes/channels.php',
        commands: __DIR__ . '/../routes/console.php',
        // health: '/up',
        then: function () {
            Route::prefix('partner')
                ->middleware('web')
                ->name('partner.')
                ->group(base_path('routes/partner.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('admin.page-login'));

        $middleware->append([RouteDetectMiddleware::class, BlockIPMiddleware::class, TrackUserActivity::class]);
        $middleware->trustProxies(at: '*');

        /**
         * middleware on web
         * middleware to run during every HTTP/HTTPS
         */
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\AdminAccessIPMiddleware::class,
        ]);

        /**
         * middleware on web
         * middleware to run during every HTTP/HTTPS
         */
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ]);

        //middleware alias
        $middleware->alias([
            'login_admin' => \App\Http\Middleware\Admin\LoginMiddleware::class,
            'login_partner' => \App\Http\Middleware\Partner\PartnerLoginMiddleware::class,
            'verify_auth_header' => \App\Http\Middleware\Api\VerifyAuthHeaderMiddleware::class,
            'check_new_notices' => \App\Http\Middleware\Partner\CheckNewNotices::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'Unauthorized'
                ], 401);
            }
        });
    })->create();
