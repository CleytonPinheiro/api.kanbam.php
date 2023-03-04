<?php
namespace Models;

use \Core\Model;

class Tarefas extends Model {

	public function getAll() {

		$sql = "SELECT tarefa, status, prazo FROM tarefa";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function getTaskByUser(int $idUser) {

		$sql = "SELECT tarefa, status, prazo FROM tarefa WHERE id_user = :id_user ORDER BY tarefa";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $idUser);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function addTarefa($tarefa, $prazo, $status, int $id_user) {

		$sql = 'INSERT INTO tarefa (tarefa, prazo, status, id_user, created_at) VALUES (:tarefa, :prazo, :status, :id_user, now())';

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tarefa', $tarefa);
		$sql->bindValue(':prazo', $prazo);
		$sql->bindValue('status', $status);
		$sql->bindValue('id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function taskById(int $id, int $idUserLogged) {
		
		$sql = "SELECT tarefa, status, prazo FROM tarefa WHERE id = :id AND id_user = :id_user";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $idUserLogged);
		$sql->bindValue(':id', $id);
		$sql->execute();
	
		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return $sql->errorInfo();
		}
	}

	public function updateTask(int $id, $task,int $idUserLogged) {

		$sql = "UPDATE tarefa SET tarefa = :tarefa, status = :status, prazo = :prazo WHERE id = :id AND id_user = :id_user";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tarefa', $task['tarefa']);
		$sql->bindValue(':status', $task['status']);
		$sql->bindValue(':prazo', $task['prazo']);
		$sql->bindValue(':id_user', $idUserLogged);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
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