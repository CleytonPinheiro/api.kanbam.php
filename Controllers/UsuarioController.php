<?php
namespace Controllers;

use Core\Controller;
use Models\Usuarios;

class UsuarioController extends Controller {

    public function index() {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'GET') {
                $usuarios = new Usuarios();
                $usuarios = $usuarios->getAll();

            if($usuarios) {
                $this->returnJson($usuarios);
            } else {
                $array['error'] = 'Não existe usuário cadastrado.';
            }
        } else {
            http_response_code(501);
            $array['error'] = 'Método requisição incompatível.';
        }

        $this->returnJson($array);
    }

    public function new() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == "POST") {
            if(!empty($data['name']) && !empty($data['email']) && !empty($data['password'])) {
                if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $usuarios = new Usuarios();
               
                    if($usuarios->create($data['name'], $data['email'], $data['password'])) {

                        $array['jwt'] = $usuarios->createJwt();
                    } else {
                        http_response_code(401);
                        $array['error'] = 'Email já cadastrado.';
                    }
                } else {
                    http_response_code(400);
                    $array['erro'] = 'Email inválido.';
                }
            } else {
                http_response_code(400);
                $array['error'] = 'Dados não preenchidos.';
            }
        } else {
            http_response_code(501);
            $array['error'] = 'Método requisição incompatível.';
        }

        $this->returnJson($array);
    }

    
    public function userById($id) {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'GET') {
            $usuarios = new Usuarios();
            $usuario = $usuarios->userById($id);

            if($usuario) {                
                $this->returnJson($usuario, 200);
            } else {
                $array['error'] = 'Usuário não encontrado.';
            }
        } else {
            http_response_code(501);
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }

    public function login() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
            if(!empty($data['email']) && !empty($data['password'])) {
                $usuarios = new Usuarios();

                if($usuarios->checkCredentials($data['email'], $data['password'])) {
                    
                    $array['jwt'] = $usuarios->createJwt();
                } else {
                    $array['error'] = 'Acesso negado.';
                }
            } else {
                http_response_code(500);
                $array['error'] = 'Email e/ou senha obrigatórios.';
            }
        } else {
            http_response_code(501);
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }
}

