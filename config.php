<?php

define("DEV_MODE", (bool)"1");
define("DATA_PATH", "/data");

if (DEV_MODE === true) {
    define("CONFIG_PATH", "/opt/demo");
} else {
    define("CONFIG_PATH", "/config");
}


