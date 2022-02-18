<?php
namespace App;



use Brace\Auth\Basic\BasicAuthToken;
use Brace\Core\AppLoader;
use Brace\Core\BraceApp;
use Brace\Core\Helper\Cookie;
use Brace\Router\Type\RouteParams;
use http\Message\Body;
use Lack\OidServer\Base\Ctrl\AuthorizeCtrl;
use Lack\OidServer\Base\Ctrl\SignInCtrl;
use Lack\OidServer\Base\Ctrl\LogoutCtrl;
use Lack\OidServer\Base\Ctrl\TokenCtrl;
use Lack\OidServer\Base\Tpl\HtmlTemplate;
use Lack\Subscription\SubscriptionManagerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequest;
use Micx\FormMailer\Config\Config;
use Phore\Mail\PhoreMailer;
use Psr\Http\Message\ServerRequestInterface;

AppLoader::extend(function (BraceApp $app) {


    $app->router->on("GET@/v1/subscription/sub/:subscription_id/client?/:client_id?",
        function (BraceApp $app, RouteParams $routeParams, BasicAuthToken $basicAuthToken, SubscriptionManagerInterface $subscriptionManager)
        {
            $subscription = $subscriptionManager->getSubscriptionById(
                $routeParams->get("subscription_id"),
                $routeParams->get("client_id"),
                $basicAuthToken->valid === true
            );
            return (array)$subscription;
        }
    );

    $app->router->on("GET@/v1/subscriptions/client/:client_id",
        function(string $body, Config $config, ServerRequest $request) use ($app)
        {

        }
    );


    $app->router->on("GET@/", function() {
        return ["system" => "micx webanalytics", "status" => "ok"];
    });

});
