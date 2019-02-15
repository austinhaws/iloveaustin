<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once '_parent_controller.php';

class account_service extends Parent_class
{
	public function login()
	{
		$this->load->model('Account_model');
		$result = false;
		$username = $this->input->post('username');
		if ($username) {
			$result = $this->Account_model->login(
				$username,
				$this->input->post('password')
			);
		}

		if ($result) {
			unset($result->password);
			if ($result->last_backup) {
				list($month, $year) = explode('/', $result->last_backup);
				$period = load_period();
			}
			if (!$result->last_backup || $year < $period['year'] || $month < $period['month']) {
				$result->destination = 'backup';
			} else {
				$result->destination = 'budget';
			}
		} else {
			$result = to_object(array('destination' => ''));
		}

		return $this->output_json($result);
	}

	public function setWeeksRemaining() {
		$this->_require_login_function('_setWeeksRemaining');
	}

 	protected function _setWeeksRemaining($data) {
 		$this->load->model('Account_model');

 		$weeks = $this->input->post('weeks');
 		$this->load->model('Account_model');
 		$this->Account_model->update_weeks_for_account_id($weeks, $this->session->userdata(SESSION_ACCOUNT)->id);

		$account = $this->session->userdata(SESSION_ACCOUNT);
		$account->weeks_remaining = $weeks;
		$this->session->set_userdata(SESSION_ACCOUNT, $account);
 	}
}
