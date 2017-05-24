<?php
class Snapshot_model extends CI_Model
{
	function read_for_account_id($account_id) {
		$this->db->where('account_id', $account_id);
		$this->db->order_by('name', 'asc');
		return $this->db->get('snapshot')->result();
	}

	function delete_with_id_for_account_id($snapshot_id, $account_id) {
		$this->db->where('id', $snapshot_id);
		$this->db->where('account_id', $account_id);
		$this->db->delete('snapshot');
	}

	public function read_by_id_for_account_id($snapshot_id, $account_id) {
		$this->db->where('id', $snapshot_id);
		$this->db->where('account_id', $account_id);
		return $this->db->get('snapshot')->row();
	}

	public function save_for_account_id($data, $account_id) {
		$this->db->where('id', $data['id']);
		$this->db->where('account_id', $account_id);
		$this->db->update('snapshot', $data);
	}

	public function add_for_account_id(&$data, $account_id) {
		$data['account_id'] = $account_id;
		$this->db->insert('snapshot', $data);
		$data['id'] = $this->db->insert_id();
	}
}
