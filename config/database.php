<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

    $capsule->addConnection( [
        'driver' => 'mysql',
        'host' => "localhost",
        'database' => "api_clases",
        'username' => "root",
        'password' => "",
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        "prefix" => "",
    ]);

    $capsule->setAsGlobal();

    $capsule->bootEloquent();

   Capsule::connection()->getPdo()->exec("SET NAMES 'utf8mb4'"); // Asegura que la conexión use UTF-8 para caracteres especiales