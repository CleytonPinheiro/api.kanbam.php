<?php
namespace Controllers;

use Core\Controller;
use Models\Tarefas;
use Models\Usuarios;

class TarefaController extends Controller {

    public function index() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $user = new Usuarios();

        if(!empty($data['jwt']) && $user->validateJwt($data['jwt'])) {
            if($method == 'GET') {
                $tarefas = new Tarefas();
                $usuario = new Usuarios();

                $usuario->validateJwt($_GET["jwt"] ?? null);
                $idUserLogged = intval($usuario->getId());

                if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

                $tarefas = $tarefas->getAll();

                if($tarefas > 0) {      
                                  
                    $this->returnJson($tarefas);
                } else {
                    $array['error'] = 'Não existe tarefa cadastrado.';
                }
            } else {
                http_response_code(501);
                $array['error'] = 'Método requisição incompatível.';
            }
        } else {
            $array['error'] = 'Acesso negado.';
        }

        $this->returnJson($array);       
    }

    public function tasksByCard(int $idCard) {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'GET') {
            $tarefa = new Tarefas();
            $usuario = new Usuarios();
            
            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

            $dataTasks = $tarefa->tasksByCard($idUserLogged, $idCard);

            if($dataTasks > 0) {                                
                $this->returnJson($dataTasks);
            } else {
                $array['error'] = 'Não existe tarefa cadastrado.';
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }

    public function getTaskByUser() {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'GET') {
            $tarefa = new Tarefas();
            $usuario = new Usuarios();
            
            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

            $dataTasks = $tarefa->getTaskByUser($idUserLogged);

            $this->returnJson($dataTasks);

            if($dataTasks > 0) {                                
                $this->returnJson($dataTasks);
            } else {
                $array['error'] = 'Não existe tarefa cadastrado.';
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }
    
    public function newTask() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
            if(!empty($data['tarefa'])) {
                $tarefa = new Tarefas();
                $usuario = new Usuarios();
             
                $usuario->validateJwt($_GET["jwt"] ?? null);
                $idUserLogged = intval($usuario->getId());

                if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

                $id_quadro = intval($data['id_quadro']);

                if($id_quadro) {
                    $task = $tarefa->addTarefa(strtolower($data['tarefa']), $id_quadro, $idUserLogged);
                } else {
                    $array['error'] = 'Campo obrigatório.';
                }
                
                $this->returnJson(['idTask' => $task, 'data' =>  $data ] );    
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }

    public function taskById(int $id) {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method === 'GET') {
            $tarefa = new Tarefas();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);
          
            if($idUserLogged) {
                $array = $tarefa->taskById($id, $idUserLogged);
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
	}

    public function deleteTask(int $id) {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'DELETE') {
            $tarefa = new Tarefas();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);
              
            if($idUserLogged) $tarefa->deleteTask($id, $idUserLogged);

            $array['msg'] = 'Deletado com sucesso.';
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }
	}

    public function updateTask(int $idTask) {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'PUT') {
            $tarefa = new Tarefas();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

            if($idUserLogged) $tarefa->updateTask($idTask, $data['tarefa'], $idUserLogged, $data['id_quadro']);
            
            $this->returnJson($data);
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }

    public function changeCard(int $idTask) {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'PATCH') {
            $tarefa = new Tarefas();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

            if($idUserLogged) $tarefa->changeCard($idTask, $data['id_quadro']);
            
            $this->returnJson($data);
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }
}