<?php

require __DIR__ . '/../vendor/autoload.php';

passthru("php artisan --env='testing' migrate:fresh  --path=database/migrations");

dump('migrated database of unit-test');
