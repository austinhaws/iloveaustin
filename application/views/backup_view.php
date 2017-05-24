<link href="<?=base_url()?>css/backup_view.less" rel="stylesheet/less" type="text/css" media="screen" />
<script src="<?=base_url()?>js/backup_view.js"></script>

<h2>You have not backed up this month!</h2>
<h3>Last Backup: <?=$last_backup?></h3>

<div id="backup-button-container">
	<a target="_blank" href="<?=base_url()?>backup/file" id="backup-button" class="fakebutton">Click Here To Run Backup</a>
</div>

<div id="backup-blurb">
	After clicking the button you will be asked to save a file. Save the file and keep it safe. If for some reason your data is lost or mangled this backup file will be your only source of getting back your information.
</div>
