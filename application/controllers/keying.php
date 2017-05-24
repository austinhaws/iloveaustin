<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Keying extends Parent_class {

	public function add() {
		$this->_require_login_function('_add');
	}

	public function edit($keying_id) {
		$this->_require_login_function('_edit', array('keying_id' => $keying_id));
	}

	public function save() {
		$this->_require_login_function('_save');
	}

	protected function _save($data) {
		$data = array(
			'id' => $this->input->post('id'),
			'date' => $this->input->post('date'),
			'num_pages' => $this->input->post('num_pages'),
			'claim_agent' => $this->input->post('claim_agent'),
			'claim_agent_note' => $this->input->post('claim_agent_note'),
			'claimant' => $this->input->post('claimant'),
			'qc' => checkbox_on($this->input->post('qc')),
			'ex' => checkbox_on($this->input->post('ex')),
			'inv' => checkbox_on($this->input->post('inv')),
			'inv_qc' => checkbox_on($this->input->post('inv_qc')),
			'inv_ex' => checkbox_on($this->input->post('inv_ex')),
			'rating' => $this->input->post('rating'),
			'note' => $this->input->post('note'),
		);

		if (!$data['id']) {
			$data['period'] = load_period();
			$data['period'] = $data['period']['combined'];
		}

		$this->load->model('Keying_model');
		if ($data['id']) {
			$this->Keying_model->save_for_account_id($data, $this->session->userdata[SESSION_ACCOUNT]->id);
		} else {
			unset($data['id']);
			$this->Keying_model->add_for_account_id($data, $this->session->userdata[SESSION_ACCOUNT]->id);
		}

		redirect('keyings');
	}

	protected function _edit($data) {
		$this->load->model('Keying_model');
		if (!($keying = $this->Keying_model->read_by_id_for_account_id($data['keying_id'], $this->session->userdata[SESSION_ACCOUNT]->id))) {
			redirect(''); // tried to access a keying that doesn't exist or doesn't belong to you
		} else {
			$data = to_array($keying);
			$data['is_editing'] = true;
			$this->_my_view($data);
		}
	}

	protected function _add($data) {
		$data['is_editing'] = false;

		$data['id'] = false;
		$data['period'] = load_period();
		$data['date'] = date('m/d/Y', time());
		$data['num_pages'] = '0';
		$data['claim_agent'] = '';
		$data['claim_agent_note'] = '';
		$data['claimant'] = '';
		$data['qc'] = '0';
		$data['ex'] = '0';
		$data['inv'] = '';
		$data['inv_qc'] = '';
		$data['inv_ex'] = '';
		$data['rating'] = '1';
		$data['note'] = '';

		$this->_my_view($data);
	}


	private function _my_view($data = array()) {
		layout(array(LAYOUT_BODY => 'keying_view',), $data);
	}

}
