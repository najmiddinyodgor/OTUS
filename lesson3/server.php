<?php

require "./vendor/autoload.php";
require "./config.php";

(new App\App($host, $port))->start();