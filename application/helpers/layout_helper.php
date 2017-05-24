<?
	function layout($pages, $data = array()) {
		$CI =& get_instance();
		$data[LAYOUT_PAGES] = $pages;

		// always include account
		$account = $CI->session->userdata(SESSION_ACCOUNT);

		// don't send confidential information
		if ($account) {
			$data[SESSION_ACCOUNT] = to_object(array(
				'id' => $account->id,
				'username' => $account->username,
			));
		}

		$CI->load->view('layout_view', $data);
	}

	function layout_piece($pages, $piece) {
		$CI =& get_instance();
		$CI->load->view($pages[$piece]);
	}
