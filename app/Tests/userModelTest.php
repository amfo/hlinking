<?php
namespace Models;
require dirname(__DIR__) . '/../config/config.php';

use PHPUnit\Framework\TestCase;

class userModelTest extends TestCase
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
	public function testCheckUser($email) {
		$userModel = new userModel();
		$this->assertContains($email, $userModel->getUserByEmail($email));

		return $email;
	}

	/**
     * @depends testCheckUser
     */
	public function testDuplicateUser($email) {
		$userModel = new userModel();
		$this->expectException(\Exception::class);
		$userModel->setUser($email, 'pass');
	}

	/**
     * @depends testCheckUser
     */
	public function testDeleteUser($email) {
		$userModel = new userModel();
		$this->assertTrue($userModel->deleteUserByEmail($email));
	}
}
