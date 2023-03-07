<?php
namespace Controllers;

use Core\Controller;
use Models\Quadros;
use Models\Usuarios;

class QuadroController extends Controller{

    public function getQuadroByUser() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $user = new Usuarios();

        if(!empty($data['jwt']) && $user->validateJwt($data['jwt'])) {
            if($method == 'GET') {
                $quadro = new Quadros();
                $usuario = new Usuarios();

                $usuario->validateJwt($_GET["jwt"] ?? null);
                $idUserLogged = intval($usuario->getId());

                if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

                $quadros = $quadro->getQuadroByUser($idUserLogged);
                
                if($quadros) {
                    $this->returnJson($quadros);
                } else {
                    $array['error'] = 'Não existe quadro cadastrado.';
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

    public function newQuadro() {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
            if(!empty($data['description'])) {
                $usuario = new Usuarios();
                $quadro = new Quadros();

                $usuario->validateJwt($_GET["jwt"] ?? null);
                $idUserLogged = $usuario->getId();

                if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);
                
                $data['description'] != '' ? $data['description'] =  $data['description'] :  $data['description'] = 'Em analise';

                $quadro->addQuadro($data['description'], $idUserLogged);

                $this->returnJson($data);
            }
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }

    public function getQuadroById($id) {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'GET') {
            $quadro = new Quadros();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

            $quadro = $quadro->getQuadroById($id, $idUserLogged);

            $this->returnJson($quadro);                 
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }
        
        $this->returnJson($array);
    }

    public function updateQuadro(int $idQuadro) {
        $array = array('error' => '');

        $method = $this->getMethod();
        $data = $this->getRequestData();
    
        if($method == 'PUT') {
            $quadro = new Quadros();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);
            
            if($idUserLogged) $quadro->updateQuadro($idQuadro, $data);

            $quadro = $quadro->getQuadroById($idQuadro);

            $this->returnJson($quadro);
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }


    public function deleteQuadro(int $id) {
        $array = array('error' => '');

        $method = $this->getMethod();

        if($method == 'DELETE') {
            $quadro = new Quadros();
            $usuario = new Usuarios();

            $usuario->validateJwt($_GET["jwt"] ?? null);
            $idUserLogged = intval($usuario->getId());

            if(!$idUserLogged) return $this->returnJson(["error" => "Acesso não autorizado."]);

            if($idUserLogged) $quadro->deleteQuadro($id, $idUserLogged);

            $array['msg'] = 'Quadro deletado com sucesso.';             
        } else {
            $array['error'] = 'Método de requisição incompatível.';
        }

        $this->returnJson($array);
    }
}   