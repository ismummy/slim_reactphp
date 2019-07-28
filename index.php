<?php

use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ReactiveSlim\Server;
use ReactiveSlim\ServerEnvironment;
use Slim\App;

require 'vendor/autoload.php';
require 'config/settings.php';
require 'controllers/HomeController.php';
require 'middlewares/IPLogMiddleware.php';

$app = new App(['settings' => $config]);

$container = $app->getContainer();

$container['logger'] = function ($c) {
    $loggerParam = $c['settings']['logger'];
    $logger = new Logger($loggerParam['name']);
    $file_handler = new StreamHandler($loggerParam['path']);
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['localDb'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['database'],
        $db['username'], $db['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['db'] = function ($container) {
    $capsule = new Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$app->get('/', 'HomeController:home');

$app->add(new IPLogMiddleware($container->get('logger')));

$checkProxyHeaders = true;
$trustedProxies = ['10.0.0.1', '10.0.0.2'];
$app->add(new RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies));
//$app->run();

(new Server($app))
    ->setEnvironment(ServerEnvironment::DEVELOPMENT)
    ->run();
