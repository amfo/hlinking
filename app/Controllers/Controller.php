<?php

namespace Controllers;

use Models\promotionModel;
use System\Sessions;
use System\Control;
use Io\Views;
use Io\Inputs;


class Controller
{
	protected $Sessions;
	protected $Input;

	public function __construct() {
		$this->Sessions = Sessions::getInstance();
		$this->Input = new Inputs();
	}

	public function dispatchUser() {
		if (!$this->Sessions->isActiveSession()) {
			Control::redirect('/login');
		}

		$user_id = $this->Sessions->getUserSession('id');
		$promotionModel = new promotionModel();
		$promotion_cursor = $promotionModel->getPromotions($user_id);
		$params = [
			'title'   => 'Promociones',
			'cursor'  => $promotion_cursor,
			'email'   => $this->Sessions->getUserSession('email'),
			'user_id' => $this->Sessions->getUserSession('id'),
		];

		Views::loadView('promotions', $params);
	}

	protected function showMessage($message, $type = 'warning', $back_page = '') {
		$back = $back_page ?: $this->Input->referrer();
		$params = [
			'title'   => ucfirst($type),
			'type'    => $type,
			'message' => $message,
			'back'    => $back
		];

		Views::loadView('message', $params);
	}
}