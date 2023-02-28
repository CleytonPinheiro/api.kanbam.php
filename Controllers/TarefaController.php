<?php
namespace Controllers;

use Core\Controller;
use Models\Tarefas;

class TarefasController extends Controller {

    public function index() {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'GET') {
                $tarefas = new Tarefas();
                $tarefas = $tarefas->index();

            if($tarefas) {
                $this->returnJson($tarefas);
            } else {
                $array['error'] = 'Não existe tarefa cadastrado.';
            }
        } else {
            http_response_code(501);
            $array['error'] = 'Método requisição incompatível.';
        }

        $this->returnJson($array);       
    }
    
    public function newTarefa() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
            if(!empty($data['tarefa']) && !empty($data['prazo'])) {
                $tarefa = new Tarefas();
                
                $tarefa->addTarefa($data['tarefa'], $data['prazo'], $data['status']);
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);        
    }

}
