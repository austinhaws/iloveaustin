<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Saving extends Parent_class {

	public function add() {
		$this->_require_login_function('_add');
	}

	public function edit($saving_id) {
		$this->_require_login_function('_edit', array('saving_id' => $saving_id));
	}

	public function save() {
		$this->_require_login_function('_save');
	}

	protected function _save($data) {
		$data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'amt_goal' => string_to_money($this->input->post('amt_goal')),
			'amt_current' => string_to_money($this->input->post('amt_current')) + string_to_money($this->input->post('amt_current_add')),
			'notes' => $this->input->post('notes'),
			'due_date' => $this->input->post('due_date'),
		);

		$this->load->model('Saving_model');
		if ($data['id']) {
			$this->Saving_model->save_for_account_id($data, $this->session->userdata[SESSION_ACCOUNT]->id);
		} else {
			unset($data['id']);
			$this->Saving_model->add_for_account_id($data, $this->session->userdata[SESSION_ACCOUNT]->id);
		}

		redirect('savings');
	}

	protected function _edit($data) {
		$this->load->model('Saving_model');
		if (!($saving = $this->Saving_model->read_by_id_for_account_id($data['saving_id'], $this->session->userdata[SESSION_ACCOUNT]->id))) {
			redirect(''); // tried to access a saving that doesn't exist or doesn't belong to you
		} else {
			$data = to_array($saving);
			$data['is_editing'] = true;
			$this->_my_view($data);
		}
	}

	protected function _add($data) {
		$data['is_editing'] = false;

		$data['id'] = false;
		$data['name'] = '';
		$data['due_date'] = '';
		$data['amt_goal'] = '';
		$data['amt_current'] = '';
		$data['notes'] = '';

		$this->_my_view($data);
	}


	private function _my_view($data = array()) {
		layout(array(LAYOUT_BODY => 'saving_view',), $data);
	}

}
