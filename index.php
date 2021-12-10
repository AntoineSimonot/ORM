<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Src\Controller\OrmController;


require 'vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$app->get('/api/{table}', function (Request $request, Response $response, array $args) {
    $table = $args['table'];
    $ormController = new OrmController();
    $result = $ormController->getAll($table);
    return $response->withJson($result);
});

$app->get('/api/{table}/{id}', function (Request $request, Response $response, array $args) {
    $table = $args['table'];
    $id = $args['id'];
    $ormController = new OrmController();
    $result = $ormController->getOne($table, $id);
    return $response->withJson($result);
});

$app->post('/api/{table}', function (Request $request, Response $response, array $args) {
    $table = $args['table'];
    $data = $request->getParsedBody();
    $ormController = new OrmController();
    $result = $ormController->create($table, $data);
    return $response->withJson($result);
});

$app->get('/api/tickets/{id}/comments', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $ormController = new OrmController();
    $result = $ormController->getComments($id);
    return $response->withJson($result);
});

$app->get('/api/tickets/{id}/export', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $ormController = new OrmController();
    $result = $ormController->exportTicket($id);
    return $response->withJson($result);
});


try {
    $app->run();
} catch (Throwable $e) {
    echo "can't run app";
}
