<?php
namespace Models;

use \Core\Model;

class Quadros extends Model {
   
    public function getQuadroByUser(int $idUserLogged) {

		$sql = "SELECT * FROM quadros WHERE id_user = :id_user ORDER BY description";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $idUserLogged);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			return $sql->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}
	
    public function addQuadro($nameQuadro, int $id_user) {

		$sql = 'INSERT INTO quadros (description, id_user, created_at) 
            VALUES (:description, :id_user, now())';

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':description', $nameQuadro);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		return $this->db->lastInsertId();

		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function deleteQuadro(int $id, int $idUser) {
		
		$sql = "DELETE FROM quadros WHERE id = :id AND id_user = :id_user";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_user', $idUser);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateQuadro(int $id, $task) {
		
        $sql = "UPDATE quadros SET description = :description WHERE id = :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':description', $task['description']);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return $sql->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
    	}
	}

	public function getQuadroById($id) {
		
		$sql = 'SELECT description FROM quadros WHERE id = :id';

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $sql->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}
}