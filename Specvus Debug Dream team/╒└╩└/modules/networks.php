<!-- Module -->
<div class="row">
	<div class="col s12">
		<h3>Active IP's</h3>

		<?php foreach($_SESSION['vm_networks']as $c0):?>

		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Expiry Time</th>
					<th>MAC address</th>
					<th>Protocol</th>
					<th>IP address</th>
					<th>Hostname</th>
					<th>Client ID or DUID</th>
				</tr>
			</thead>
			<tbody>

			<?php $h1='';$r2='';exec('virsh net-dhcp-leases '.$c0,$h1,$r2);if(isset($h1)&&!empty($h1)){$n3->create_table_active_ips_rows($h1,'  ',6,'center-align');}?>

			</tbody>
		</table>
		<blockquote>Network &ldquo;<?php echo $c0;?>&rdquo;</blockquote>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($h1);var_dump($r2);?></pre> -->

		<?php endforeach;?>

	</div>
</div>