<?php

namespace App;


use Brace\Auth\Basic\AuthBasicMiddleware;
use Brace\Auth\Basic\Validator\ClientIdFileAuthValidator;
use Brace\Body\BodyMiddleware;
use Brace\Core\AppLoader;
use Brace\Core\Base\ExceptionHandlerMiddleware;
use Brace\Core\Base\JsonReturnFormatter;
use Brace\Core\Base\NotFoundMiddleware;
use Brace\Core\BraceApp;
use Brace\CORS\CorsMiddleware;
use Brace\Router\RouterDispatchMiddleware;
use Brace\Router\RouterEvalMiddleware;
use Brace\Router\Type\RouteParams;
use Brace\Session\SessionMiddleware;
use Brace\Session\Storages\CookieSessionStorage;
use Lack\Subscription\SubscriptionManagerInterface;
use Micx\FormMailer\Config\Config;
use Micx\Subscription\Config\TConfig;


AppLoader::extend(function (BraceApp $app) {

    $app->setPipe([
        new BodyMiddleware(),
        new AuthBasicMiddleware(new ClientIdFileAuthValidator(CONFIG_PATH . "/clients.yml")),
        new RouterEvalMiddleware(),
        new CorsMiddleware([], function (string $subscriptionId, SubscriptionManagerInterface $subscriptionManager, RouteParams $routeParams, string $origin) {
            return $subscriptionManager->getSubscriptionById($routeParams->get("subscription_id"))->isAllowedOrigin($origin);
        }),


        new ExceptionHandlerMiddleware(),
        new RouterDispatchMiddleware([
            new JsonReturnFormatter($app)
        ]),
        new NotFoundMiddleware()
    ]);
});
