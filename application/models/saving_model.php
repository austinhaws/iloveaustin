<?php
class Saving_model extends CI_Model
{

	public function read_savings_by_account_id($account_id) {
		$this->db->where('account_id', $account_id);
		$this->db->order_by('name', 'asc');
		return $this->db->get('savings')->result();
	}

	public function read_by_id_for_account_id($savings_id, $account_id) {
		$this->db->where('id', $savings_id);
		$this->db->where('account_id', $account_id);
		return $this->db->get('savings')->row();
	}

	public function delete_with_id_for_account_id($savings_id, $account_id) {
		$this->db->where('id', $savings_id);
		$this->db->where('account_id', $account_id);
		$this->db->delete('savings');
	}

	public function save_for_account_id($data, $account_id) {
		$this->db->where('id', $data['id']);
		$this->db->where('account_id', $account_id);
		$this->db->update('savings', $data);
	}

	public function add_for_account_id(&$data, $account_id) {
		$data['account_id'] = $account_id;
		$this->db->insert('savings', $data);
		$data['id'] = $this->db->insert_id();
	}
}
