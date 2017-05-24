<?
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

		<script src="<?=base_url()?>js/jquery-1.8.1.min.js"></script>

		<script src="<?=base_url()?>js/global.js"></script>
		<script src="<?=base_url()?>js/layout_view.js"></script>
		<script>
			<?/*because js files can't have php in them w/o some pain just put php constants in this globals object */?>
			var globals = {

				<?/* - hack for having base url in js files*/?>
			    base_url: '<?php echo base_url(); ?>'
			};
		</script>
	</head>
	<body>
		<div id="content">
			<div id="header" class="<?=isset($player_account) ? $player_account->username : ''?>"></div>
			<div id="menu">
				<ul id="navCircle">
				  <li><a href="<?=base_url()?>" class="<?=${LAYOUT_PAGES}[LAYOUT_BODY] == 'login_view' ? 'current' : ''?>">Home</a></li>
				<?	if (is_logged_in()) {	?>
				  <li><a href="<?=base_url()?>budget" class="<?=${LAYOUT_PAGES}[LAYOUT_BODY] == 'budget_view' ? 'current' : ''?>">Budget</a></li>
				  <li><a href="<?=base_url()?>savings" class="<?=${LAYOUT_PAGES}[LAYOUT_BODY] == 'savings_view' ? 'current' : ''?>">Savings</a></li>
				  <li><a href="<?=base_url()?>keyings" class="<?=${LAYOUT_PAGES}[LAYOUT_BODY] == 'keyings_view' ? 'current' : ''?>">Keying</a></li>
				  <li><a href="<?=base_url()?>graphs" class="<?=${LAYOUT_PAGES}[LAYOUT_BODY] == 'graphs_view' ? 'current' : ''?>">Graphs</a></li>
				  <li><a href="<?=base_url()?>games" class="<?=${LAYOUT_PAGES}[LAYOUT_BODY] == 'games_view' ? 'current' : ''?>">Games</a></li>
				<?	}	?>
			  <? if (is_logged_in()) {	?>
				  <li><a href="<?=base_url()?>login/logoutUser">Logout</a></li>
			  <? } ?>
				</ul>
			</div>
			<?	layout_piece(${LAYOUT_PAGES}, LAYOUT_BODY);	?>
		</div>
		<div id="footer">v4.0 Design by <a href="http://www.mitchinson.net"> www.mitchinson.net</a> | This work is licensed under a <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a> </div>
	</body>

	<?=form_open('', array('id' => 'post_form'))?>
	<?/* use form_open so that csrf code is placed on the page*/?>
	<?=form_close()?>

	<script>
		localStorage.clear(); // less css files are stored by the browser in the cache and are tremendously difficult to refresh; this forces the refresh (DEV ONLY!)
	</script>
	<script src="<?=base_url()?>js/less-1.3.0.min.js"></script>
</html>
