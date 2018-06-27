<?php

namespace Controllers;

use Models\promotionModel;
use System\Control;
use Io\Views;

final class UserController extends Controller
{
	const INVALID_PROMOTION = 'Promoción no válida';
	private $user_id;

	public function __construct() {
		parent::__construct();

		if (!$this->Sessions->isActiveSession()) {
			Control::redirect('/login');
		}

		$this->user_id = $this->Sessions->getUserSession('id');
	}

	public function confirmUserPromotion() {
		$params = [
			'title' => 'Confirmar nueva promoción'
		];

		Views::loadView('confirm_promotion', $params);
	}

	public function insertUserPromotion() {
		$promotionModel = new promotionModel();
		$promotionModel->setPromotion($this->user_id);
		Control::redirect('/');
	}

	public function confirmCheckUserPromotion($vars) {
		extract($vars);
		$id = (int)$id;

		if (!$id) {
			$this->showMessage(self::INVALID_PROMOTION, 'error', '/');
		}

		$params = [
			'title' => 'Canjear promoción',
			'id'    => $id
		];

		Views::loadView('check_promotion', $params);
	}

	public function checkUserPromotion() {
		$id = (int)$this->Input->post('id');
		$promotionModel = new promotionModel();
		$promotionModel->checkPromotion($id, $this->user_id);
		Control::redirect('/');
	}
}