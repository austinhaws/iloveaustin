<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parent_class extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('layout');
	}


	// -- access helper -- //
	protected function _require_login_function($name, $data = array()) {
		if (is_logged_in()) {

			$this->include_account($data);

			$this->$name($data);
		} else {
			redirect('');
		}
	}

	protected function _run_role_function($function_name, $role, $data = array()) {
		if (has_role($role)) {
			$this->include_account($data);
			$this->$function_name($data);
		} else {
			redirect('');
		}
	}

	protected function output_json($data)
	{
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	private function include_account(&$data) {
		// give everyone the user!
		$account = $this->session->userdata(SESSION_ACCOUNT);

		// don't send confidential information
		$data[SESSION_ACCOUNT] = to_object(array(
			'id' => $account->id,
			'username' => $account->username,
		));
	}
}
