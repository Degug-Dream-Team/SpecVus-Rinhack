<!-- Module -->
<div class="row">
	<div class="col s12">
		<h3>Active IP's</h3>

		<?php foreach($_SESSION['vm_networks']as $h0):?>

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

			<?php $e1='';$a2='';exec('virsh net-dhcp-leases '.$h0,$e1,$a2);if(isset($e1)&&!empty($e1)){$y3->create_table_active_ips_rows($e1,'  ',6,'center-align');}?>

			</tbody>
		</table>
		<blockquote>Network &ldquo;<?php echo $h0;?>&rdquo;</blockquote>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($e1);var_dump($a2);?></pre> -->

		<?php endforeach;?>

	</div>
</div>