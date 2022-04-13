<?php
namespace App;


use Brace\Core\AppLoader;
use Brace\Core\BraceApp;
use Micx\FormMailer\Stats\FileStatsRunner;
use Rudl\LibGitDb\RudlGitDbClient;

AppLoader::extend(function (BraceApp $app) {


    $app->command->addCommand("syncgitops", function(array $argv) {
        $runner = new RudlGitDbClient();
        $runner->loadClientConfigFromEnv();
        $runner->syncObjects(SUBSCRIOPTION_SCOPE, DATA_PATH);
    });

    // Send yesterdays report at 00:05:00 (specified by 1)
    $app->command->addInterval("* * * * *", "syncgitops", [1], true);

});
