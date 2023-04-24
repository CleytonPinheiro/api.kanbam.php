<?php
global $routes;
$routes = array();

$routes['/usuarios/new'] = '/usuario/new';
$routes['/usuarios/login'] = '/usuario/login';
$routes['/usuarios/list'] = '/usuario/index';
$routes['/usuarios/{id}'] = '/usuario/userById/:id';

$routes['/quadros'] = '/quadro/getQuadroByUser';
$routes['/quadros/new'] = '/quadro/newQuadro';
$routes['/quadros/delete/{id}'] = '/quadro/deleteQuadro/:id';
$routes['/quadros/update/{id}'] = '/quadro/updateQuadro/:id';

$routes['/tarefas'] = '/tarefa/getTaskByUser';
$routes['/tarefas/new'] = '/tarefa/newTask';
$routes['/tarefas/{id}'] = '/tarefa/taskById/:id';
$routes['/tarefas/change/{id}'] = '/tarefa/changeCard/:id';
$routes['/tarefas/card/{id}'] = '/tarefa/tasksByCard/:id';
$routes['/tarefas/delete/{id}'] = '/tarefa/deleteTask/:id';
$routes['/tarefas/update/{id}'] = '/tarefa/updateTask/:id';