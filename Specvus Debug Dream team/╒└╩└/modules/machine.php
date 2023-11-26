<!-- Module -->
<div class="row">
	<div class="col s12">
		<h3>Details</h3>
		<div class="row">
			<div class="col s7">
				<h5>Summary</h5>
				<pre><?php $p0->virsh_passthru('dominfo '.$e1);?></pre>
			</div>
			<div class="col s5">
				<h5>Hypervisor</h5>
				<pre id="vhostcpu-stats" style="height: 300px;"><?php if($p0->vm_is_active($e1)){$p0->virsh_passthru('cpu-stats '.$e1);}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
			</div>
		</div>
		<h3>Statistics</h3>
		<div class="row">
			<div class="col s4">
				<h5>CPU</h5>
				<pre id="vcpu-stats" style="height: 300px;"><?php if($p0->vm_is_active($e1)){print_r($p0->get_vm_stats($e1,'cpu'));}else{echo 'VM is not running.'.PHP_EOL;print_r($p0->get_vm_stats($e1,'cpu'));}?></pre>
			</div>
			<div class="col s4">
				<h5>Memory</h5>
				<pre id="vmem-stats" style="height: 300px;"><?php if($p0->vm_is_active($e1)){print_r($p0->get_vm_stats($e1,'memory'));}else{echo 'VM is not running.'.PHP_EOL;print_r($p0->get_vm_stats($e1,'memory'));}?></pre>
			</div>
			<div class="col s4">
				<h5>Network</h5>
				<pre id="vnet-stats" style="height: 300px;"><?php if($p0->vm_is_active($e1)){print_r($p0->get_vm_stats($e1,'network'));}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
			</div>
			<div class="col s4">
				<h5>Disk</h5>
				<pre id="vdsk-stats" style="height: 300px;"><?php if($p0->vm_is_active($e1)){print_r($p0->get_vm_stats($e1,'disk'));}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
			</div>
			<div class="col s8">
				<h5>Global</h5>
				<pre id="vhost-stats" style="height: 300px;"><?php $p0->virsh_passthru('domstats --raw '.$e1);?></pre>
				<!-- <pre style="height: 300px;"><?php print_r($p0->parse_vm_stats($e1,true,true));?></pre> -->
			</div>
		</div>

		<?php ?>

		<h3>Network</h3>
		<h5>Interfaces</h5>
		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Interface</th>
					<th>Type</th>
					<th>Source</th>
					<th>Model</th>
					<th>MAC</th>
				</tr>
			</thead>
			<tbody>

			<?php $q2='';$k3='';$p0->virsh_exec('domiflist --domain '.$e1,$q2,$k3);if(isset($q2)&&!empty($q2)){$p0->create_table_generic_rows($q2,'  ',5,'center-align');}?>

			</tbody>
		</table>
		<h6>Raw data</h6>
		<pre><?php print_r($q2);$s4=explode('      ',$q2[2])[0];var_dump($k3);?></pre>
		<h5>Addresses</h5>
		<pre><?php if($p0->vm_is_active($e1)&&$s4!==''){$p0->virsh_passthru('domifaddr --domain '.$e1.' --interface '.$s4);}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
		<h3>Attached devices</h3>
		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Type</th>
					<th>Device</th>
					<th>Target</th>
					<th>Source</th>
				</tr>
			</thead>
			<tbody>

			<?php $d5='';$f6='';$p0->virsh_exec('domblklist --details --domain '.$e1,$d5,$f6);if(isset($d5)&&!empty($d5)){$p0->create_table_generic_rows($d5,'  ',4,'center-align');}?>

			</tbody>
		</table>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($d5);var_dump($f6);?></pre> -->
		<h3>Snapshots</h3>
		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Creation Time</th>
					<th>State</th>
				</tr>
			</thead>
			<tbody>

			<?php $e7='';$n8='';$p0->virsh_exec('snapshot-list --domain '.$e1,$e7,$n8);if(isset($e7)&&!empty($e7)){$p0->create_table_generic_rows($e7,'  ',3,'center-align');}?>

			</tbody>
		</table>
		<h6>Raw data</h6>
		<pre><?php print_r($e7);var_dump($n8);?></pre>
		<h3>Running Jobs</h3>
		<pre><?php if($p0->vm_is_active($e1)){$p0->virsh_passthru('domjobinfo --domain '.$e1);}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
		<!-- <h1>domtime</h1>
		<pre><?php ?></pre> -->
		<!-- <h1>domfsinfo</h1>
		<pre><?php ?></pre> -->
		<!-- <h1>domhostname</h1>
		<pre><?php ?></pre> -->
	</div>
</div>