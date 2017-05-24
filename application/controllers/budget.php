<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Budget extends Parent_class {

	public function __construct() {
		parent::__construct();
	}

	private function copy_monthlies_from_last_month($last_period, $this_period) {
		$account_id = $this->session->userdata(SESSION_ACCOUNT)->id;
		$this->load->model('Monthly_model');
		$old_monthlys = $this->monthly_model->read_by_account_id_for_period($account_id, $last_period['combined']);

		foreach ($old_monthlys as $monthly) {
			$this->Monthly_model->add_for_account_id(array(
				'period' => $this_period['combined'],
				'name' => $monthly->name,
				'notes' => $monthly->notes,
				'amt_goal' => $monthly->amt_goal,
				'amt_spent' => '000',

			), $account_id);
		}
	}

	public function index($month = false, $year = false) {
		$this->_require_login_function('_budget', array('month' => $month, 'year' => $year, ));
	}

 	public function budget($month = false, $year = false) {
		$this->_require_login_function('_budget', array('month' => $month, 'year' => $year, ));
 	}

 	public function delete_snapshot($snapshot_id) {
 		$this->_require_login_function('_delete_snapshot', array('snapshot_id' => $snapshot_id));
 	}

 	public function delete_monthly($monthly_id) {
 		$this->_require_login_function('_delete_monthly', array('monthly_id' => $monthly_id));
 	}

 	protected function _delete_monthly($data) {
 		if ($data['monthly_id']) {
 			$this->load->model('Monthly_model');
 			$this->Monthly_model->delete_with_id_for_account_id($data['monthly_id'], $this->session->userdata(SESSION_ACCOUNT)->id);
 		}
 		$this->_my_view();
 	}

 	protected function _delete_snapshot($data) {
 		if ($data['snapshot_id']) {
 			$this->load->model('Snapshot_model');
 			$this->Snapshot_model->delete_with_id_for_account_id($data['snapshot_id'], $this->session->userdata(SESSION_ACCOUNT)->id);
 		}
 		$this->_my_view();
 	}

	protected function _budget($data) {
		$this->_my_view($data);
	}

	private function _my_view($data = array()) {
		$this->load->model(array(
			'snapshot_model',
			'monthly_model',
		));

		// Account
		$data['account'] = $this->session->userdata(SESSION_ACCOUNT);

		// Periods
		load_period_into_data($data);
		$data['current_period'] = load_period(false, false);
		if (!isset($data['month'])) {
			$data['month'] = $data['current_period']['month'];
		}
		if (!isset($data['year'])) {
			$data['year'] = $data['current_period']['year'];
		}
		$data['period'] = load_period($data['month'], $data['year']);
		$data['next_period'] = next_period($data['period']);
		$data['last_period'] = last_period($data['period']);

		// Snapshots
		$data['snapshots'] = $this->snapshot_model->read_for_account_id($data['account']->id);
		$data['snapshots_totals'] = array(
			'amt_goal' => 0,
			'amt_current' => 0,
			'amt_goal_not_totalable' => 0,
			'amt_current_not_totalable' => 0,
		);
		foreach ($data['snapshots'] as $snapshot) {
			if ($snapshot->is_totalable) {
				$data['snapshots_totals']['amt_goal'] += $snapshot->amt_goal;
				$data['snapshots_totals']['amt_current'] += $snapshot->amt_current;
			} else {
				$data['snapshots_totals']['amt_goal_not_totalable'] += $snapshot->amt_goal;
				$data['snapshots_totals']['amt_current_not_totalable'] += $snapshot->amt_current;
			}
		}

		// Monthlies
		$data['monthlies'] = $this->monthly_model->read_by_account_id_for_period($data['account']->id, $data['period']['combined']);
		if (!$data['monthlies']) {
			$this->copy_monthlies_from_last_month($data['last_period'], $data['period']);
			$data['monthlies'] = $this->monthly_model->read_by_account_id_for_period($data['account']->id, $data['period']['combined']);
		}
		$data['monthly_totals'] = array('amt_goal' => 0, 'amt_spent' => 0, 'amt_left' => 0);
		foreach ($data['monthlies'] as $monthly) {
			$data['monthly_totals']['amt_goal'] += $monthly->amt_goal;
			$data['monthly_totals']['amt_spent'] += $monthly->amt_spent;
			$data['monthly_totals']['amt_left'] += $monthly->amt_goal - $monthly->amt_spent;
		}

		// Has next / previous
		$data['has_previous'] = 0 < count($this->monthly_model->read_by_account_id_for_period($data['account']->id, $data['last_period']['combined']));
		$data['has_next'] = 0 < count($this->monthly_model->read_by_account_id_for_period($data['account']->id, $data['next_period']['combined']));

		layout(array(LAYOUT_BODY => 'budget_view',), $data);
	}

}
