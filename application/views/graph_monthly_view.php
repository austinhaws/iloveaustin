<script src="https://www.google.com/jsapi"></script>
<script src="<?=base_url()?>js/graph_monthly_view.js"></script>
<link href="<?=base_url()?>css/graph_monthly_view.less" rel="stylesheet/less" type="text/css" media="screen" />

<script>
	globals.monthlies = <?=$monthly?>;
	globals.monthly_name = <?=json_encode($name)?>;
	globals.charts = {}; // loads with the google created charts
</script>

<div id="charts-container"></div>

