<script src="https://www.google.com/jsapi"></script>
<script src="<?php echo base_url()?>js/graphs_view.js"></script>
<link href="<?php echo base_url()?>css/graphs_view.less" rel="stylesheet/less" type="text/css" media="screen" />

<script>
	globals.monthlies = <?php echo $monthlies?>;
	globals.charts = {}; // loads with the google created charts
//	console.log(globals);
</script>

	<div class="page_title">
		<div class="title-container">
			<a href="<?php echo base_url()?>graphs/graph/<?php echo $last_period['month']?>/<?php echo $last_period['year']?>"><img src="<?php echo base_url()?>images/arrow_left.png" /></a>
			<div class="title"><?php echo $period['combined']?></div>
			<a href="<?php echo base_url()?>graphs/graph/<?php echo $next_period['month']?>/<?php echo $next_period['year']?>"><img src="<?php echo base_url()?>images/arrow_right.png" /></a>
		</div>
		<?php if ($period['combined'] != $current_period['combined']) { ?>
			<div class="goto-current"><a href="<?php echo base_url()?>graphs/graph/<?php echo $current_period['month']?>/<?php echo $current_period['year']?>">Go To Current Month</a></div>
		<?php } ?>
	</div>

<div id="charts-explanation">Click a pie piece to see details on that monthly expense</div>
<div id="charts-container"></div>

