<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Login extends Parent_class {

	public function index() {
		if (is_logged_in()) {
			$last_backup = $this->session->userdata(SESSION_ACCOUNT)->last_backup;
			if ($last_backup) {
				list($month, $year) = explode('/', $this->session->userdata(SESSION_ACCOUNT)->last_backup);
			}
			$period = load_period();
			if (!$last_backup || $year > $period['year'] || $month > $period['month']) {
				redirect('backup');
			} else {
				redirect('budget');
			}
		} else {
			$this->_my_view();
		}
	}

	public function logoutUser() {
		$this->session->sess_destroy();

		redirect('');
	}


	private function _my_view($data = array()) {
		layout(array(LAYOUT_BODY => 'login_view',), array());
	}

}
