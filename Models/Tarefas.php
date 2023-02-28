<?php
namespace Models;

use \Core\Model;

class Tarefas extends Model {
	
	public function index() {

		$sql = "SELECT * FROM tarefa";
		$sql = $this->db->prepare($sql);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function addTarefa($tarefa, $prazo, $status = 'A fazer') {
		$sql = 'INSERT INTO tarefa (tarefa, prazo, status) VALUES (:tarefa, :prazo, :status)';
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tarefa', $tarefa);
		$sql->bindValue(':prazo', $prazo);
		$sql->bindValue('status', $status);

		$sql->execute();

		return $sql;
	}

	public function delTarefa($id) {
		$this->db->query("DELETE FROM tarefa WHERE id = '$id'");
	}

	public function updateStatus($status, $id) {
		$this->db->query("UPDATE tarefa SET status = '$status' WHERE id = '$id'");
	}
}