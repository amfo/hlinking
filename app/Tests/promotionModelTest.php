<?php

namespace Models;
require dirname(__DIR__) . '/../config/config.php';

use PHPUnit\Framework\TestCase;

class promotionModelTest extends TestCase
{
	public function testAddUser() {
		$email = 'email' . time() . '@test.com';
		$userModel = new userModel();
		$this->assertGreaterThan(0, $userModel->setUser($email, 'pass'));

		return $email;
	}

	/**
	 * @depends testAddUser
	 */
	public function testSetPromotion($email) {
		$userModel = new userModel();
		$promotionModel = new promotionModel();
		$user = $userModel->getUserByEmail($email);
		$this->assertContains($email, $user);
		$promotion_id = $promotionModel->setPromotion($users['id']);
		$this->assertGreaterThan(0, $promotion_id);

		return [
			'promotion_id' => $promotion_id,
			'email'        => $email
		];
	}

	/**
	 * @depends testSetPromotion
	 */
	public function testGetPromotionById(array $promotion_data) {
		$promotionModel = new promotionModel();
		$userModel = new userModel();
		$this->assertInternalType('array', $promotionModel->getPromotionById($promotion_data['promotion_id']));

		return $promotion_data['email'];
	}

	/**
	 * @depends testGetPromotionById
	 */
	public function testDeleteUser($email) {
		$userModel = new userModel();
		$this->assertTrue($userModel->deleteUserByEmail($email));
	}
}
