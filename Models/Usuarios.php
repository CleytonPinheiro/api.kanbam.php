<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Usuarios extends Model {

	private $id_user;

	public function getAll() {

		$sql = "SELECT * FROM user";
		$sql = $this->db->query($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}	

	public function userById($id) {

		$sql = "SELECT id, name, email FROM user WHERE id = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}	
	}

	public function create($name, $email, $password) {

		if(!$this->emailExiste($email)) {		

			$hash = password_hash($password, PASSWORD_DEFAULT);
		
			$sql = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':name', $name);
			$sql->bindValue(':email', $email);
			$sql->bindValue(':password', $hash);			
			$sql->execute();
			
			
			$this->id_user = $this->db->lastInsertId();
			
			return true;
		} else {
			return false;
		}
	}

	public function createJwt() {
		$jwt = new Jwt();

		return $jwt->create(array('id_user' => $this->id_user));
	}

	public function validateJwt($token) {
		$jwt = new Jwt();
		$info = $jwt->validate($token);

		if(isset($info->id_user)) {
			$this->id_user = $info->id_user;
			return true;
		} else {
			return false;
		}
	}

	public function checkCredentials($email, $password) {
		
		$sql = "SELECT id, password FROM user WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':email', $email);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$info = $sql->fetch();
			
			if(password_verify($password, $info['password'])) {
				
				$this->id_user = $info['id'];
				return true;
			} else {
				return false;
			}
		} else {	
			return false;
		}
	}

	public function getId() {
		return $this->id_user;
	}

	private function emailExiste($email) {

		$sql = 'SELECT id FROM user WHERE email = :email';
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':email', $email);
		$sql->execute();

		if($sql->rowCount() > 0) {			
			return true;			
		} else {			
			return false;
		}
	}
}