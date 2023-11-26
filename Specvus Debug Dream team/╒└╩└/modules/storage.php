<!-- Module -->
<div class="row">
	<div class="col s12">
		<h3>Storage Pools</h3>
		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>State</th>
					<th>Autostart</th>
					<th>Persistent</th>
					<th>Capacity</th>
					<th>Allocation</th>
					<th>Available</th>
				</tr>
			</thead>
			<tbody>

			<?php $x0='';$l1='';exec('virsh pool-list --all --details',$x0,$l1);if(isset($x0)&&!empty($x0)){$d2->create_table_generic_rows($x0,'  ',7,'center-align');}?>

			</tbody>
		</table>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($x0);var_dump($l1);?></pre> -->
	</div>
</div>
<div class="row">
	<div class="col s12">
		<h3>Volumes</h3>
		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Path</th>
					<th>Type</th>
					<th>Capacity</th>
					<th>Allocation</th>
				</tr>
			</thead>
			<tbody>

			<?php $c3='';$s4='';exec('virsh vol-list --details --pool default',$c3,$s4);if(isset($c3)&&!empty($c3)){$d2->create_table_generic_rows($c3,' ',5,'center-align');}?>

			</tbody>
		</table>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($c3);var_dump($s4);?></pre> -->
	</div>
</div>