<?php

namespace Controllers;

use Io\Views;
use Models\userModel;
use System\Control;

final class RegisterController extends Controller
{
	const CSRF_WARNING = 'Posible intento de usurpación de identidad';
	const BAD_EMAIL = 'Email incorrecto';
	const BAD_PASS = 'Contraseña vacía o las contraseñas no son iguales';
	const SHORT_PASS = 'La contraseña es demasiado corta';
	const MIN_PASS_LENGTH = 8;

	public function viewRegisterUser() {
		$csrf = hash('sha512', openssl_random_pseudo_bytes(32));
		$this->Sessions->setGlobalSession('csrf', $csrf);
		$params = [
			'title' => 'Registro',
			'csrf'  => $csrf
		];

		Views::loadView('signup', $params);
	}

	public function setRegisterUser() {
		$email = $this->Input->post('email');
		$password = $this->Input->post('passwd');
		$csrf = $this->Input->post('csrf');

		if ($csrf != $this->Sessions->getGlobalSession('csrf')) {
			$this->showMessage(self::CSRF_WARNING, 'error');
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->showMessage(self::BAD_EMAIL, 'error');
		} else if (empty($password) || $password != $this->Input->post('passwd2')) {
			$this->showMessage(self::BAD_PASS, 'error');
		} else if (grapheme_strlen($password) < self::MIN_PASS_LENGTH) {
			$this->showMessage(self::SHORT_PASS, 'error');
		} else {
			$userModel = new userModel();
			try {
				$user_id = $userModel->setUser($email, $password);
				$this->Sessions->setUserSession('id', $user_id);
				$this->Sessions->setUserSession('email', $email);
				Control::redirect('/');
			} catch (\Exception $exception) {
				$this->showMessage($exception->getMessage(), 'error');
			}
		}
	}
}