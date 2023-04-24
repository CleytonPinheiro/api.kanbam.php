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
                        $array['error'] = 'Email já cadastrado.';
                    }
                } else {
                    $array['erro'] = 'Email inválido.';
                }
            } else {
                $array['error'] = 'Dados não preenchidos.';
            }
        } else {
            $array['error'] = 'Método requisição incompatível.';
        }

        $this->returnJson($array);
    }
    
    public function userById($id) {
        $array = array('error' => '', 'logged' => false);

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $user = new Usuarios();
        
        if(!empty($data['jwt']) && $user->validateJwt($data['jwt'])) {
            $array['logged'] = true;
            $array['is_me'] =  false;

            if($id == $user->getId()) {
                $array['is_me'] = true;
            }

            if($method === 'GET') {
                $array['data'] = $user->getInfo($id);

                if(count($array['data']) === 0) {
                    $array['error'] = 'Usuário não existe.';
                }
            } else {
                $array['error'] = 'Método '.$method.' não disponível.';
            }
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
                $array['error'] = 'Email e/ou senha obrigatórios.';
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }
    
        $this->returnJson($array);
    }
}