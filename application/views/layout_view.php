<?php
	$CI =& get_instance();

	$CI->load->helper('url');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>I Love Austin</title>

		<meta name="description" content="I Love Austin" />
		<meta name="author" content="Austin" />

		<script src="<?php echo base_url()?>js/jquery-1.8.1.min.js"></script>

		<script src="<?php echo base_url()?>js/global.js"></script>
		<script src="<?php echo base_url()?>js/layout_view.js"></script>
		<script>
			<?php /*because js files can't have php in them w/o some pain just put php constants in this globals object */ ?>
			var globals = {

				<?php /* - hack for having base url in js files*/ ?>
			    base_url: '<?php echo base_url(); ?>'
			};
		</script>
	</head>
	<body>
		<div id="content">
			<div id="header" class="<?php echo isset($player_account) ? $player_account->username : ''?>"></div>
			<div id="menu">
				<ul id="navCircle">
				  <li><a href="<?php echo base_url()?>" class="<?php echo ${LAYOUT_PAGES}[LAYOUT_BODY] == 'login_view' ? 'current' : ''?>">Home</a></li>
				<?php  	if (is_logged_in()) {	?>
				  <li><a href="<?php echo base_url()?>budget" class="<?php echo ${LAYOUT_PAGES}[LAYOUT_BODY] == 'budget_view' ? 'current' : ''?>">Budget</a></li>
				  <li><a href="<?php echo base_url()?>savings" class="<?php echo ${LAYOUT_PAGES}[LAYOUT_BODY] == 'savings_view' ? 'current' : ''?>">Savings</a></li>
				  <li><a href="<?php echo base_url()?>keyings" class="<?php echo ${LAYOUT_PAGES}[LAYOUT_BODY] == 'keyings_view' ? 'current' : ''?>">Keying</a></li>
				  <li><a href="<?php echo base_url()?>graphs" class="<?php echo ${LAYOUT_PAGES}[LAYOUT_BODY] == 'graphs_view' ? 'current' : ''?>">Graphs</a></li>
				  <li><a href="<?php echo base_url()?>games" class="<?php echo ${LAYOUT_PAGES}[LAYOUT_BODY] == 'games_view' ? 'current' : ''?>">Games</a></li>
				<?php  	}	?>
			  <?php if (is_logged_in()) {	?>
				  <li><a href="<?php echo base_url()?>login/logoutUser">Logout</a></li>
			  <?php } ?>
				</ul>
			</div>
			<?php  	layout_piece(${LAYOUT_PAGES}, LAYOUT_BODY);	?>
		</div>
		<div id="footer">v4.0 Design by <a href="http://www.mitchinson.net"> www.mitchinson.net</a> | This work is licensed under a <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a> </div>
	</body>

	<?php echo form_open('', array('id' => 'post_form'))?>
	<?php  /* use form_open so that csrf code is placed on the page*/?>
	<?php echo form_close()?>

	<script>
		localStorage.clear(); // less css files are stored by the browser in the cache and are tremendously difficult to refresh; this forces the refresh (DEV ONLY!)
	</script>
	<script src="<?php echo base_url()?>js/less-1.3.0.min.js"></script>
</html>
