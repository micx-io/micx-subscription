<?php

define("DEV_MODE", (bool)"1");


if (DEV_MODE === true) {
    define("DATA_PATH", "/opt/demo");
    define("DATA_CSV_PATH", "/opt/demo/subscriptions.csv");
} else {
    define("DATA_PATH", "/data");
    define("DATA_CSV_PATH", "/data/subscriptions.csv");
}

define("RUDL_GITDB_URL", "");
define("RUDL_GITDB_CLIENT_ID", "");
define("RUDL_GITDB_CLIENT_SECRET", "");
define("SUBSCRIOPTION_SCOPE", "subscriptions");
