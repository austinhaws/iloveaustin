<script src="https://www.google.com/jsapi"></script>
<script src="<?=base_url()?>js/graphs_view.js"></script>
<link href="<?=base_url()?>css/graphs_view.less" rel="stylesheet/less" type="text/css" media="screen" />

<script>
	globals.monthlies = <?=$monthlies?>;
	globals.charts = {}; // loads with the google created charts
//	console.log(globals);
</script>

	<div class="page_title">
		<div class="title-container">
			<a href="<?=base_url()?>graphs/graph/<?=$last_period['month']?>/<?=$last_period['year']?>"><img src="<?=base_url()?>images/arrow_left.png" /></a>
			<div class="title"><?=$period['combined']?></div>
			<a href="<?=base_url()?>graphs/graph/<?=$next_period['month']?>/<?=$next_period['year']?>"><img src="<?=base_url()?>images/arrow_right.png" /></a>
		</div>
		<? if ($period['combined'] != $current_period['combined']) { ?>
			<div class="goto-current"><a href="<?=base_url()?>graphs/graph/<?=$current_period['month']?>/<?=$current_period['year']?>">Go To Current Month</a></div>
		<? } ?>
	</div>

<div id="charts-explanation">Click a pie piece to see details on that monthly expense</div>
<div id="charts-container"></div>

