<?php
global $routes;
$routes = array();

$routes['/usuarios/new'] = '/usuario/new';
$routes['/usuarios/login'] = '/usuario/login';
$routes['/usuarios/list'] = '/usuario/index';
$routes['/usuarios/{id}'] = '/usuario/userById/:id';


$routes['tarefas'] = '/tarefa/index';
$routes['/tarefas/new'] = '/tarefas/addTarefa';
$routes['/tarefas/{id}/user'] = '/tarefas/user/:id';
