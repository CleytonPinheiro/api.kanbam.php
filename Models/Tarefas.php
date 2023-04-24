<?php
namespace Models;

use \Core\Model;

class Tarefas extends Model {

	public function getAll() {

		$sql = "SELECT tarefa, status FROM tarefa";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function tasksByCard(int $idUserLogged, int $idCard) {

		$sql = 'SELECT * FROM tarefa WHERE id_user = :id_user AND id_quadro = :id_quadro';

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $idUserLogged);
		$sql->bindValue(':id_quadro', $idCard);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function getTaskByUser(int $idUser) {

		$sql = 'SELECT * FROM tarefa JOIN quadros ON tarefa.id_quadro = quadros.id WHERE tarefa.id_user = :id_user';

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $idUser);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function addTarefa($tarefa, int $id_quadro, int $id_user) {
		
		$sql = 'INSERT INTO tarefa (tarefa, id_user, id_quadro) VALUES (:tarefa, :id_user, :id_quadro)';

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tarefa', $tarefa);
		$sql->bindValue('id_user', $id_user);
		$sql->bindValue('id_quadro', $id_quadro);	
		$sql->execute();

		return $this->db->lastInsertId();

		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}		
	}

	public function checkIdQuadro($task) {

		$sql = 'SELECT id_quadro FROM tarefa WHERE tarefa = :tarefa';
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tarefa', $task);
		$sql->execute();

		if($sql->rowCount() > 0) {		
			return $sql->fetch(\PDO::FETCH_ASSOC);		
		} else {			
			return false;
		}
	}

	public function taskById(int $id) {
		
		$sql = "SELECT id, tarefa, id_quadro FROM tarefa WHERE id = :id";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
	
		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return $sql->errorInfo();
		}
	}

	public function updateTask(int $id, $task, int $idUser, int $idQuadro) {
		
		$sql = "UPDATE tarefa SET tarefa = :tarefa, id_user = :id_user, id_quadro = :id_quadro WHERE id = :id";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tarefa', $task);
		$sql->bindValue(':id_user', $idUser);
		$sql->bindValue(':id_quadro', $idQuadro);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() === 1) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function changeCard($id, $idQuadro) {
		
		$sql = "UPDATE tarefa SET id_quadro = :id_quadro WHERE id = :id";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_quadro', $idQuadro);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() === 1) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function deleteTask(int $id, int $idUser) {
		
		$sql = "DELETE FROM tarefa WHERE id = :id AND id_user = :id_user";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_user', $idUser);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}
}