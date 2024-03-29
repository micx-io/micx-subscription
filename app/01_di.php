<?php
namespace App;

use Brace\Auth\Basic\AuthBasicMiddleware;
use Brace\Auth\Basic\Validator\ClientIdFileAuthValidator;
use Brace\Command\CommandModule;
use Brace\Core\AppLoader;
use Brace\Core\BraceApp;
use Brace\Dbg\BraceDbg;
use Brace\Mod\Request\Zend\BraceRequestLaminasModule;
use Brace\Router\RouterModule;
use Brace\Router\Type\RouteParams;
use Lack\Subscription\Manager\CsvFileTemplateSubscriptionManager;
use Lack\Subscription\Manager\FileSubscriptionManager;
use Lack\Subscription\Manager\MultiSubscriptionManager;
use Micx\Subscription\Config\TConfig;
use Phore\Di\Container\Producer\DiService;
use Phore\Di\Container\Producer\DiValue;
use Psr\Http\Message\ServerRequestInterface;


BraceDbg::SetupEnvironment(true, ["192.168.178.20", "localhost", "localhost:8080", "formmailer.srv.infracamp.org"]);


AppLoader::extend(function () {
    $app = new BraceApp();
    $app->addModule(new BraceRequestLaminasModule());
    $app->addModule(new RouterModule());
    $app->addModule(new CommandModule());


    $app->define("app", new DiValue($app));

    $app->define("config", new DiService(function () {
        return phore_file(DATA_PATH . "/clients.yml")->get_yaml(TConfig::class);
    }));

    $app->define("subscriptionManager", new DiService(function (RouteParams $routeParams) {
        $sm = new MultiSubscriptionManager([
            new FileSubscriptionManager(DATA_PATH),
            new CsvFileTemplateSubscriptionManager(DATA_CSV_PATH)
        ]);
        $sm->setClientId($routeParams->get("client_id"));
        return $sm;
    }));

    return $app;
});
