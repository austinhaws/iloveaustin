<?php
class Monthly_model extends CI_Model
{

	// period is mm/yyyy
	public function read_by_account_id_for_period($account_id, $period) {
		$this->db->where('account_id', $account_id);
		$this->db->where('period', $period);
		$this->db->order_by('name', 'asc');
		return $this->db->get('monthly')->result();
	}

	public function read_by_id_for_account_id($monthly_id, $account_id) {
		$this->db->where('id', $monthly_id);
		$this->db->where('account_id', $account_id);
		return $this->db->get('monthly')->row();
	}

	public function delete_with_id_for_account_id($monthly_id, $account_id) {
		$this->db->where('id', $monthly_id);
		$this->db->where('account_id', $account_id);
		$this->db->delete('monthly');
	}

	public function save_for_account_id($data, $account_id) {
		$this->db->where('id', $data['id']);
		$this->db->where('account_id', $account_id);
		$this->db->update('monthly', $data);
	}

	public function add_for_account_id($data, $account_id) {
		$data['account_id'] = $account_id;
		$this->db->insert('monthly', $data);
		return $this->db->insert_id();
	}

	public function read_by_account_id_group_name($account_id) {
		$this->db->select('name, SUM(amt_goal) amt_goal, SUM(amt_spent) amt_spent');
		$this->db->where('account_id', $account_id);
		$this->db->group_by('name');
		return $this->db->get('monthly')->result();
	}

	public function read_by_account_id_for_name($account_id, $name) {
		$this->db->where('account_id', $account_id);
		$this->db->where('name', $name);
		return $this->db->get('monthly')->result();
	}
}
