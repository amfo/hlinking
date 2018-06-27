<?php
namespace Models;

final class promotionModel extends Model {

	public function getPromotions($user_id) {
		$stmt = $this->prepare("SELECT id, code, checked FROM promotions WHERE user_id = :user_id");
		$stmt->bindParam(':user_id', $user_id, self::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	public function getPromotionById($id) {
		$stmt = $this->prepare("SELECT id, user_id, code, checked FROM promotions WHERE id = :id LIMIT 1");
		$stmt->bindParam(':id', $id, self::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetchAll();

		return isset($row[0]) ? $row[0] : null;
	}

	/*
	 * Si en el caso improbable fallara la generación del código de promoción por duplicidad,
	 * se intentaría recursivamente hasta que resuelva una id única.
	*/
	public function setPromotion($user_id) {
		$uuid = uniqid();
		$stmt = $this->prepare("INSERT INTO promotions (user_id, code) VALUES (:user_id, :code)");
		$stmt->bindParam(':user_id', $user_id, self::PARAM_INT);
		$stmt->bindParam(':code', $uuid, self::PARAM_STR);

		$stmt->execute();
		$err = $stmt->errorInfo();

		if (is_array($err) && isset($err[1]) && $err[1] == self::DUPLICATE_KEY_CODE) {
			$this->setPromotion();
		}

		return $this->lastInsertId();
	}

	public function checkPromotion($id, $user_id) {
		$stmt = $this->prepare("UPDATE promotions SET checked = 1 WHERE id = :id AND user_id = :user_id");
		$stmt->bindParam(':id', $id, self::PARAM_INT);
		$stmt->bindParam(':user_id', $user_id, self::PARAM_INT);

		$stmt->execute();
	}
}