<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Savings extends Parent_class {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->_require_login_function('_savings');
	}

 	public function savings() {
		$this->_require_login_function('_savings');
 	}

 	public function delete($saving_id) {
 		$this->_require_login_function('_delete', array('saving_id' => $saving_id));
 	}

 	protected function _delete($data) {
 		$this->load->model('Saving_model');
 		$this->Saving_model->delete_with_id_for_account_id($data['saving_id'], $this->session->userdata(SESSION_ACCOUNT)->id);
 		$this->_my_view();
 	}

	protected function _savings($data) {
		$this->_my_view($data);
	}

	private function _my_view($data = array()) {
		$this->load->model('Saving_model');
		$data['savings'] = $this->Saving_model->read_savings_by_account_id($this->session->userdata(SESSION_ACCOUNT)->id);
		$data['total_goal'] = 0;
		$data['total_current'] = 0;
		foreach ($data['savings'] as $saving) {
			$data['total_goal'] += $saving->amt_goal;
			$data['total_current'] += $saving->amt_current;
		}

		layout(array(LAYOUT_BODY => 'savings_view',), $data);
	}

}
