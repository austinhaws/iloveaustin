<?php
class Game_model extends CI_Model
{

	public function select_games($data) {
		$this->db->select('game.*');
		$this->db->select('(SELECT count(*) FROM game_play WHERE game_play.game_id = game.id) AS plays');
		$this->db->from('game');
		$this->db->where($data);
		$this->db->order_by('name', 'asc');
		return $this->db->get()->result();
	}


	public function save_play($account_id, $game_id, $winner) {
		$games = $this->select_games(array('account_id' => $account_id, 'id' => $game_id,));
		if (!$games || count($games) != 1) {
			pprint_r($this->db->last_query());
			exit('Game does not belong to this account');
		}

		$this->db->set('winner', $winner);
		$this->db->set('game_id', $game_id);
		$this->db->insert('game_play');
	}
}
