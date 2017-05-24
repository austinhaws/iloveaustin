<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Snapshot extends Parent_class {

	public function add($month, $year) {
		$this->_require_login_function('_add', array(
			'month' => $month,
			'year' => $year,
		));
	}

	public function edit($snapshot_id, $month = false, $year = false) {
		$this->_require_login_function('_edit', array(
			'snapshot_id' => $snapshot_id,
			'month' => $month,
			'year' => $year,
		));
	}

	public function save() {
		$this->_require_login_function('_save');
	}

	protected function _save($data) {
		$data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'amt_goal' => string_to_money($this->input->post('goal')),
			'amt_current' => string_to_money($this->input->post('current'))  + string_to_money($this->input->post('current_add')),
			'notes' => $this->input->post('notes'),
			'is_totalable' => ($this->input->post('is_totalable') == '1' ? 1 : 0),
		);

		$this->load->model('Snapshot_model');
		if ($data['id']) {
			$this->Snapshot_model->save_for_account_id($data, $this->session->userdata[SESSION_ACCOUNT]->id);
		} else {
			unset($data['id']);
			$this->Snapshot_model->add_for_account_id($data, $this->session->userdata[SESSION_ACCOUNT]->id);
		}

		redirect('budget/budget/' . $this->input->post('month') . '/' . $this->input->post('year'));
	}

	protected function _edit($data) {
		$this->load->model('Snapshot_model');
		if (!($snapshot = $this->Snapshot_model->read_by_id_for_account_id($data['snapshot_id'], $this->session->userdata[SESSION_ACCOUNT]->id))) {
			redirect(''); // tried to access a snapshot that doesn't exist or doesn't belong to you
		} else {
			$data = array_merge($data, to_array($snapshot));
			$data['is_editing'] = true;
			$this->_my_view($data);
		}
	}

	protected function _add($data) {
		$data['is_editing'] = false;

		$data['id'] = false;
		$data['amt_goal'] = 0;
		$data['amt_current'] = 0;
		$data['name'] = '';
		$data['notes'] = '';
		$data['is_totalable'] = 1;

		$this->_my_view($data);
	}


	private function _my_view($data = array()) {
		$data['current_add'] = '';
		layout(array(LAYOUT_BODY => 'snapshot_view',), $data);
	}

}
