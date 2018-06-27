<?php
namespace Models;

final class userModel extends Model
{

	public function setUser($email, $password) {
		$crypt_password = password_hash($password, PASSWORD_BCRYPT);

		$stmt = $this->prepare("INSERT INTO users (email, password) VALUES (:email, :pass)");
		$stmt->bindParam(':email', $email, self::PARAM_STR);
		$stmt->bindParam(':pass', $crypt_password, self::PARAM_STR);

		$stmt->execute();
		$err = $stmt->errorInfo();
		if (is_array($err) && isset($err[2])) {
			throw new \Exception($err[2]);
		}

		return $this->lastInsertId();
	}

	public function getUserByEmail($email) {
		$stmt = $this->prepare("SELECT id, email, password FROM users WHERE email = :email LIMIT 1");
		$stmt->bindParam(':email', $email, self::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetchAll();

		return isset($row[0]) ? $row[0] : [];
	}

	public function getUsers($limit = 10) {
		$stmt = $this->prepare("SELECT id, email FROM users LIMIT :limit");
		$stmt->bindParam(':limit', $limit, self::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll();

		return $rows;
	}

	/*
	 * Las promociones relacionadas con el usuario se deben borrar en cascada según la definición en el esquema
	 */
	public function deleteUserByEmail($email) {
		$stmt = $this->prepare("DELETE FROM users WHERE email = :email");
		$stmt->bindParam(':email', $email, self::PARAM_STR);
		$stmt->execute();

		return !!$stmt->rowCount();
	}
}