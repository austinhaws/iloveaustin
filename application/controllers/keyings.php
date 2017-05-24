<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Keyings extends Parent_class {

	public function __construct() {
		parent::__construct();
	}

	public function index($month = false, $year = false) {
		$this->_require_login_function('_keyings', array('month' => $month, 'year' => $year, ));
	}

 	public function keyings($month = false, $year = false) {
		$this->_require_login_function('_keyings', array('month' => $month, 'year' => $year, ));
 	}

 	public function delete_keying($keying_id) {
 		$this->_require_login_function('_delete_keying', array('keying_id' => $keying_id));
 	}


 	protected function _delete_keying($data) {
 		if ($data['keying_id']) {
 			$this->load->model('Keying_model');
 			$this->Keying_model->delete_with_id_for_account_id($data['keying_id'], $this->session->userdata(SESSION_ACCOUNT)->id);
 		}
 		$this->_my_view();
 	}

	protected function _keyings($data) {
		$this->_my_view($data);
	}

	private function _my_view($data = array()) {
		$this->load->model('Keying_model');

		// Account
		$data['account'] = $this->session->userdata(SESSION_ACCOUNT);

		// Periods
		load_period_into_data($data);

		// Keyings
		$data['keyings'] = $this->Keying_model->read_by_account_id_for_period($data['account']->id, $data['period']['combined']);

		// Keying Earnings
		$data['keying_total'] = 0;
		$data['keying_total_earned'] = 0.0;
		foreach ($data['keyings'] as $keying) {
			$data['keying_total'] += $keying->num_pages;
			if ($keying->inv) {
				$data['keying_total_earned'] += $keying->num_pages * 1.47;
			} else if ($keying->inv_qc && $keying->inv_ex) {
				$data['keying_total_earned'] += $keying->num_pages * 2.07;
			} else if ($keying->inv_qc || $keying->inv_ex) {
				$data['keying_total_earned'] += $keying->num_pages * 1.77;

			} else if ($keying->qc && $keying->ex) {
				$data['keying_total_earned'] += $keying->num_pages * 1.58;
			} else if ($keying->qc || $keying->ex) {
				$data['keying_total_earned'] += $keying->num_pages * 1.38;
			} else {
				$data['keying_total_earned'] += $keying->num_pages * 1.18;
			}
		}


		// Agents
		$agents = $this->Keying_model->read_agent_totals_for_account_id($data['account']->id);
		foreach ($agents as $agent) {
			$agent->rating_formatted = number_format($agent->rating, 2);
		}
		$data['agents'] = json_encode($agents);
		$data['total_files'] = 0;
		foreach ($agents as $agent) {
			$data['total_files'] += $agent->num_files;
		}

		layout(array(LAYOUT_BODY => 'keyings_view',), $data);
	}

}
