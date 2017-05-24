<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Games extends Parent_class {

	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$this->_require_login_function('_games');
	}

	public function played() {
		$this->_require_login_function('_played');
	}

	protected function _played($data = array()) {
		$this->load->model('game_model');
		$this->game_model->save_play($data[SESSION_ACCOUNT]->id, $this->input->post('game_id'), $this->input->post('winner'));
	}

	protected function _games($data = array()) {
		$this->load->model('game_model');

		$data['games'] = json_encode($this->game_model->select_games(array('account_id' => $data[SESSION_ACCOUNT]->id)));

		// show view
		layout(array(LAYOUT_BODY => 'games_view',), $data);
	}

}
