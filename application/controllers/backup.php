<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include '_parent_controller.php';

class Backup extends Parent_class {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->_require_login_function('_index');
	}

	public function backup() {
		$this->_require_login_function('_index');
	}

	public function file() {
		$this->_require_login_function('_file');
	}

	protected function _index($data = array()) {
		$last_backup = $this->session->userdata(SESSION_ACCOUNT)->last_backup;
		if (!$last_backup) {
			$last_backup = 'Never';
		}

		layout(array(LAYOUT_BODY => 'backup_view',), array(
			'last_backup' => $last_backup,
		));
	}

	protected function _file($data = array()) {
		$period = load_period();

		$this->load->model('Account_model');
		$this->Account_model->update_backup_date_for_account_id($period['combined'], $this->session->userdata(SESSION_ACCOUNT)->id);

		$this->load->helper('download');
		$this->load->dbutil();

		$filename = 'ILoveAustinBackup-' . $period['combined'] . '.zip';
		force_download($filename, $this->dbutil->backup(array(
			'format' => 'gzip',
		)));
	}
}
