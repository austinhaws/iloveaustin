<?php
class Account_model extends CI_Model
{
	public function login($username, $password)
	{
		$result = false;

		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$account = $this->db->get('account')->row();

		if ($account) {
			$this->session->set_userdata(SESSION_ACCOUNT, $account);
		} else {
			$this->session->sess_destroy();
		}

		return $account ? $account : false;
	}

	public function update_weeks_for_account_id($weeks, $account_id) {
		$this->db->where('id', $account_id);
		$this->db->update('account', array('weeks_remaining' => $weeks));
	}

	private function crypt_apr1_md5_check($plainpasswd, $encryptedpasswd) {
		$passwd = explode("$", $encryptedpasswd);
		return $this->crypt_apr1_md5($plainpasswd, $passwd[2]);
	}

	private function crypt_apr1_md5($plainpasswd, $salt = false) {
		if (!$salt) {
			$salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
		}
		$len = strlen($plainpasswd);
		$text = $plainpasswd.'$apr1$'.$salt;
		$bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
		for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
		for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd{0}; }
		$bin = pack("H32", md5($text));
		for($i = 0; $i < 1000; $i++) {
			$new = ($i & 1) ? $plainpasswd : $bin;
			if ($i % 3) $new .= $salt;
			if ($i % 7) $new .= $plainpasswd;
			$new .= ($i & 1) ? $bin : $plainpasswd;
			$bin = pack("H32", md5($new));
		}
		$tmp='';
		for ($i = 0; $i < 5; $i++) {
			$k = $i + 6;
			$j = $i + 12;
			if ($j == 16) $j = 5;
			$tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
		}
		$tmp = chr(0).chr(0).$bin[11].$tmp;
		$tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
		"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
		"./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
		return "$"."apr1"."$".$salt."$".$tmp;
	}

	public function update_backup_date_for_account_id($period, $account_id) {
		$this->db->where('id', $account_id);
		$this->db->update('account', array('last_backup' => $period));
		$account = $this->session->userdata(SESSION_ACCOUNT);
		$account->last_backup = $period;
		$this->session->set_userdata(SESSION_ACCOUNT, $account);
	}
}
