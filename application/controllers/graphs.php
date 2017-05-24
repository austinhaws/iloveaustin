<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Graphs extends Parent_class {

	public function __construct() {
		parent::__construct();
	}


	public function index($month = false, $year = false) {
		$this->_require_login_function('_graph', array('month' => $month, 'year' => $year, ));
	}

	public function graph($month = false, $year = false) {
		$this->_require_login_function('_graph', array('month' => $month, 'year' => $year, ));
	}

	public function monthly($name) {
		$this->_require_login_function('_monthly', array('name' => urldecode($name)));
	}

	protected function _monthly($data = array()) {
		$this->load->model('monthly_model');

		$account = $this->session->userdata(SESSION_ACCOUNT);

		// load data just for the one name
		$monthlies = $this->monthly_model->read_by_account_id_for_name($account->id, $data['name']);

		$data['monthly'] = array();
		foreach ($monthlies as $monthly) {
			if ($monthly->amt_goal || $monthly->amt_spent) {
				$data['monthly'][] = array(
					'name' => $monthly->name,
					'amt_goal' => $monthly->amt_goal / 100.00,
					'amt_spent' => $monthly->amt_spent / 100.00,
					'period' => $monthly->period,
					'url' => urlencode($monthly->name),
				);
			}
		}

		// sort by period
		usort($data['monthly'], function($a, $b) {
			list($month1, $year1) = explode('/', $a['period']);
			list($month2, $year2) = explode('/', $b['period']);

			return (
				$year1 < $year2 ? -1 :
					(
						$year1 > $year2 ? 1 :
						(
							$month1 < $month2 ? -1 : (
								$month1 > $month2 ? 1 : 0
							)
						)
					)
			);
		});

//		pprint_r($data, 'data', true);

		$data['monthly'] = json_encode($data['monthly']);

		// show view
		layout(array(LAYOUT_BODY => 'graph_monthly_view',), $data);
	}

	protected function _graph($data = array()) {
		$this->load->model('monthly_model');

		// Account
		$data['account'] = $this->session->userdata(SESSION_ACCOUNT);

		// load period
		load_period_into_data($data);

		// graph data
		$data['monthlies'] = array();
		// - monthly goals
		$monthlies = $this->monthly_model->read_by_account_id_for_period($data['account']->id, $data['period']['combined']);
		$data['monthlies']['monthly_goals'] = array();
		foreach ($monthlies as $monthly) {
			if ($monthly->amt_goal) {
				$data['monthlies']['monthly_goals'][] = array(
					'name' => $monthly->name,
					'amount' => $monthly->amt_goal / 100.00,
					'url' => urlencode($monthly->name),
				);
			}
		}

		// - monthly spent
		$data['monthlies']['monthly_spent'] = array();
		foreach ($monthlies as $monthly) {
			if ($monthly->amt_spent) {
				$data['monthlies']['monthly_spent'][] = array(
					'name' => $monthly->name,
					'amount' => $monthly->amt_spent / 100.00,
					'url' => urlencode($monthly->name),
				);
			}
		}

		// - all monthlies
		$all_monthlies = $this->monthly_model->read_by_account_id_group_name($data['account']->id);
		// -- spent
		$data['monthlies']['monthly_all_spent'] = array();
		foreach ($all_monthlies as $monthly) {
			if ($monthly->amt_spent) {
				$data['monthlies']['monthly_all_spent'][] = array(
					'name' => $monthly->name,
					'amount' => $monthly->amt_spent / 100.00,
					'url' => urlencode($monthly->name),
				);
			}
		}

		// -- goals
		$data['monthlies']['monthly_all_goal'] = array();
		foreach ($all_monthlies as $monthly) {
			if ($monthly->amt_goal) {
				$data['monthlies']['monthly_all_goal'][] = array(
					'name' => $monthly->name,
					'amount' => $monthly->amt_goal / 100.00,
					'url' => urlencode($monthly->name),
				);
			}
		}

//pprint_r($data['monthlies'], 'datamonthlies', true);
		// json encode monthlies
		$data['monthlies'] = json_encode($data['monthlies']);

//pprint_r($monthlies, 'monthlies', true);

		// show view
		layout(array(LAYOUT_BODY => 'graphs_view',), $data);
	}

}
