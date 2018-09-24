<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Islandora\Crayfish\Commons\Provider\IslandoraServiceProvider;
use Islandora\Crayfish\Commons\Provider\YamlConfigServiceProvider;
use Islandora\Homarus\Controller\HomarusController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


$app = new Application();

$app->register(new IslandoraServiceProvider());
$app->register(new YamlConfigServiceProvider(__DIR__ . '/../cfg/config.yaml'));


$app['homarus.controller'] = function ($app) {
  return new HomarusController(
    $app['crayfish.cmd_execute_service'],
    $app['monolog']
  );
};

$app->get('/sayYo', "homarus.controller:sayYo");

$app->get('/convert', "homarus.controller:convert")
  ->before(function (Request $request, Application $app) {
    return $app['crayfish.apix_middleware']->before($request);
  });


$app->get('/sayHello', function () {
  return "Hello World";
});

return $app;
