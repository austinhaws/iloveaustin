<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Monthly extends Parent_class {

	public function add($month, $year) {
		$this->_require_login_function('_add', array('month' => $month, 'year' => $month,));
	}

	public function edit($monthly_id) {
		$this->_require_login_function('_edit', array('monthly_id' => $monthly_id));
	}

	public function save() {
		$this->_require_login_function('_save');
	}

	protected function _save($data) {
		$data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'amt_goal' => string_to_money($this->input->post('goal')),
			'amt_spent' => string_to_money($this->input->post('spent')) + string_to_money($this->input->post('spent_add')),
			'notes' => $this->input->post('notes'),
		);

		$this->load->model('Monthly_model');
		$account = $this->session->userdata[SESSION_ACCOUNT];
		if ($data['id']) {
			$this->Monthly_model->save_for_account_id($data, $account->id);
		} else {
			$data['period'] = $this->input->post('period');
			unset($data['id']);
			$data['id'] = $this->Monthly_model->add_for_account_id($data, $account->id);
		}

		// read data to get its period for the url
		$data = $this->Monthly_model->read_by_id_for_account_id($data['id'], $account->id);

		redirect('budget/budget/' . $data->period);
	}

	protected function _edit($data) {
		$this->load->model('Monthly_model');
		if (!($monthly = $this->Monthly_model->read_by_id_for_account_id($data['monthly_id'], $this->session->userdata[SESSION_ACCOUNT]->id))) {
			redirect(''); // tried to access a monthly that doesn't exist or doesn't belong to you
		} else {
			$data = to_array($monthly);
			$data['is_editing'] = true;
			list($data['month'], $data['year']) = explode('/', $data['period']);
			$this->_my_view($data);
		}
	}

	protected function _add($data) {
		$data['is_editing'] = false;

		$data['id'] = false;
		$data['amt_goal'] = 0;
		$data['amt_spent'] = 0;
		$data['name'] = '';
		$data['due_date'] = '';
		$data['notes'] = '';
		$data['period'] = load_period();
		$data['period'] = $data['period']['combined'];

		$this->_my_view($data);
	}


	private function _my_view($data = array()) {
		layout(array(LAYOUT_BODY => 'monthly_view',), $data);
	}

}
