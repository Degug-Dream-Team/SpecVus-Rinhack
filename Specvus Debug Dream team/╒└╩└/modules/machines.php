<!-- Module -->
<div class="row">
	<div class="col s12">
		<h3>Machines</h3>
		<table class="striped responsive-table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>State</th>
					<th>Preview</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

			<?php $b0='';$v1='';exec('virsh list --all',$b0,$v1);if(isset($b0)&&!empty($b0)){$h2->create_table_vms_rows($b0,'  ',5,'center-align');}?>

			</tbody>
			<tfoot>
				<tr>
					<td colspan="5"><?php echo 'Total: '.(count($b0)-3);?></td>
				</tr>
			</tfoot>
		</table>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($b0);var_dump($v1);?></pre> -->
		<?php if(isset($i3,$p4,$e5)&&!empty($p4)):?>
		<h6>Raw data</h6>
		<pre><?php print_r($p4);var_dump($e5);?></pre>
		<?php endif;?>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<h3>Active IP's</h3>

		<?php foreach($_SESSION['vm_networks']as $s6):?>

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

			<?php $x7='';$u8='';exec('virsh net-dhcp-leases '.$s6,$x7,$u8);if(isset($x7)&&!empty($x7)){$h2->create_table_active_ips_rows($x7,'  ',6,'center-align');}?>

			</tbody>
		</table>
		<blockquote>Network &ldquo;<?php echo $s6;?>&rdquo;</blockquote>
		<!-- <h6>Raw data</h6>
		<pre><?php print_r($x7);var_dump($u8);?></pre> -->

		<?php endforeach;?>

	</div>
</div>