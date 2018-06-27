<?php

namespace Controllers;

use Io\Views;
use System\Control;
use Models\userModel;

final class LoginController extends Controller
{
	const CSRF_WARNING = 'Posible intento de usurpación de identidad';
	const BAD_EMAIL = 'Email incorrecto';
	const BAD_USER_PASS = 'Email o contraseña no válidos. Puede que no se haya registrado';

	public function viewLoginUser() {
		$this->checkLogged();
		$csrf = hash('sha512', openssl_random_pseudo_bytes(32));
		$this->Sessions->setGlobalSession('csrf', $csrf);
		$params = [
			'title' => 'Acceso',
			'csrf'  => $csrf
		];

		Views::loadView('login', $params);
	}

	public function setLoginUser() {
		$this->checkLogged();
		$email = $this->Input->post('email');
		$password = $this->Input->post('passwd');
		$csrf = $this->Input->post('csrf');

		if ($csrf != $this->Sessions->getGlobalSession('csrf')) {
			$this->showMessage(self::CSRF_WARNING, 'error');
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->showMessage(self::BAD_EMAIL, 'error');
		} else {
			$userModel = new userModel();
			$user_data = $userModel->getUserByEmail($email);
			if (!password_verify($password, $user_data['password'])) {
				$this->showMessage(self::BAD_USER_PASS, 'error');
				return;
			}

			$this->Sessions->setUserSession('id', $user_data['id']);
			$this->Sessions->setUserSession('email', $email);
			Control::redirect('/');
		}
	}

	public function logoutUser() {
		$this->Sessions->destroySession();
		Control::redirect('/login');
	}

	private function checkLogged() {
		if ($this->Sessions->isActiveSession()) {
			Control::redirect('/');
		}
	}
}