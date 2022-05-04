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
            if ($basicAuthToken->hasCredentials) {
                if ($routeParams->get("client_id") !== $basicAuthToken->user)
                    throw new \InvalidArgumentException("Credentials do not apply to client_id");
            }
            $subscription = $subscriptionManager->getSubscriptionById(
                $routeParams->get("subscription_id"),
                $basicAuthToken->valid === true
            );
            return (array)$subscription;
        }
    );

    $app->router->on("GET@/v1/subscription/client/:client_id",
        function(RouteParams $routeParams, ServerRequest $request, BasicAuthToken $basicAuthToken, SubscriptionManagerInterface $subscriptionManager) use ($app)
        {
            $basicAuthToken->validate();
            return $subscriptionManager->getSubscriptionsByClientId($routeParams->get("client_id"));
        }
    );


    $app->router->on("GET@/", function() {
        return ["system" => "micx subscription", "status" => "ok"];
    });

});
