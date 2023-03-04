<?php
global $routes;
$routes = array();

$routes['/usuarios/new'] = '/usuario/new';
$routes['/usuarios/login'] = '/usuario/login';
$routes['/usuarios/list'] = '/usuario/index';
$routes['/usuarios/{id}'] = '/usuario/userById/:id';


$routes['/tarefas'] = '/tarefa/getTaskByUser';
$routes['/tarefas/new'] = '/tarefa/newTask';
$routes['/tarefas/{id}'] = '/tarefa/taskById/:id';
$routes['/tarefas/delete/{id}'] = '/tarefa/deleteTask/:id';
$routes['/tarefas/update/{id}'] = '/tarefa/updateTask/:id';

