<?php

session_start();

use Router\Router;

spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});

$pseudo = isset($_SESSION['pseudo']) ?  $_SESSION['pseudo'] : null;

$router = new Router($_GET['url']);
$router->get('/', function($id){ echo "Bienvenue sur ma homepage !"; });
$router->get('/login', 'Authentification#login');
$router->post('/login', 'Authentification#login');
$router->get('/logout', 'Authentification#logout');
$router->get('/chat', 'Chat#index');
$router->post('/add', 'Chat#add');
$router->get('/refresh', 'Chat#refresh');
$router->run($pseudo);