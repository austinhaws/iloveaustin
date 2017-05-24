<?php
class Keying_model extends CI_Model
{
	// period is mm/yyyy
	public function read_by_account_id_for_period($account_id, $period) {
		$this->db->where('account_id', $account_id);
		$this->db->where('period', $period);
		$this->db->order_by('claim_agent', 'asc');
		return $this->db->get('keying')->result();
	}

	public function read_by_id_for_account_id($keying_id, $account_id) {
		$this->db->where('id', $keying_id);
		$this->db->where('account_id', $account_id);
		return $this->db->get('keying')->row();
	}

	public function delete_with_id_for_account_id($keying_id, $account_id) {
		$this->db->where('id', $keying_id);
		$this->db->where('account_id', $account_id);
		$this->db->delete('keying');
	}

	public function save_for_account_id($data, $account_id) {
		$this->db->where('id', $data['id']);
		$this->db->where('account_id', $account_id);
		$this->db->update('keying', $data);
	}

	public function add_for_account_id(&$data, $account_id) {
		$data['account_id'] = $account_id;
		$this->db->insert('keying', $data);
		$data['id'] = $this->db->insert_id();
	}

	public function read_agent_totals_for_account_id($account_id) {
		$this->db->select(array('claim_agent', 'AVG(rating) rating', "count(*) num_files, IFNULL(GROUP_CONCAT(if (claim_agent_note ='', null, claim_agent_note) SEPARATOR '<br />'), '') comments"));
		$this->db->where('account_id', $account_id);
		$this->db->group_by('claim_agent');
		$this->db->order_by('claim_agent');
		return $this->db->get('keying')->result();
	}
}
