<script src="https://www.google.com/jsapi"></script>
<script src="<?php echo base_url()?>js/graph_monthly_view.js"></script>
<link href="<?php echo base_url()?>css/graph_monthly_view.less" rel="stylesheet/less" type="text/css" media="screen" />

<script>
	globals.monthlies = <?php echo $monthly?>;
	globals.monthly_name = <?php echo json_encode($name)?>;
	globals.charts = {}; // loads with the google created charts
</script>

<div id="charts-container"></div>

