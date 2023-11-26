<?php if(preg_match('/\.(?:png|jpg|jpeg|gif|ico|js|css)$/',$_SERVER["REQUEST_URI"])){return false;}require_once 'inc/bootstrap.php';?>
<!DOCTYPE html>
<html>
<head>
	<!-- Import Google Icon Font -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- Import materialize.css -->
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection">

	<!-- Let browser know website is optimized for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Block favicon requests -->
	<link rel="icon" href="data:,">

	<title><___></title>

	<!-- Custom style -->
	<style>
	body {
		display: flex;
		min-height: 100vh;
		flex-direction: column;
	}
	blockquote {
		border-left-color: #039be5;
	}
	main {
		flex: 1 0 auto;
	}
	i.material-icons {
		vertical-align: middle;
	}
	.dropdown-content li>a, .dropdown-content li>span {
		color: #039be5;
	}
	#sidenav-overlay {
		z-index: 996;
	}
	</style>
</head>

<body>
	<header>
		<div class="navbar-fixed">
			<nav class="grey darken-4 white-text">
				<div class="nav-wrapper">
					<a href="./" class="brand-logo"><i class="material-icons">developer_board</i></a>
					<a href="#" data-activates="mobile-demo" class="button-collapse">1<i class="material-icons">menu</i></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="?module=dsh" class="tooltipped" data-position="bottom" data-tooltip="Show dashboard"><i class="material-icons left">dashboard</i>Dashboard</a></li>
						<li><a href="./" class="tooltipped" data-position="bottom" data-tooltip="Show modules"><i class="material-icons left">apps</i>Modules</a></li>

						<li><a href="#!" onclick="window.location.reload();" class="tooltipped" data-position="bottom" data-tooltip="Refresh"><i class="material-icons left">refresh</i>Refresh</a></li>
						<li><a href="#!" class="dropdown-button" data-activates="settings-dropdown" data-hover="false" data-alignment="right" data-belowOrigin="true"><i class="material-icons left">settings</i>Settings<i class="material-icons right">arrow_drop_down</i></a></li>
					</ul>
					<ul id="settings-dropdown" class="dropdown-content">
						<li><a href="#!" class="display-expand"><i class="material-icons left">swap_horiz</i>Expand display</a></li>
						<li><a href="#modal-connect" class="modal-trigger"><i class="material-icons left">settings_ethernet</i>Connection</a></li>
						<li class="divider"></li>
						<li><a href="#!">Other</a></li>
					</ul>
					<ul class="side-nav" id="mobile-demo">
						<li><a href="?module=dsh" class="tooltipped" data-position="bottom" data-tooltip="Show dashboard"><i class="material-icons left">dashboard</i>Dashboard</a></li>
						<li><a href="./" class="tooltipped" data-position="bottom" data-tooltip="Show modules"><i class="material-icons left">apps</i>Modules</a></li>
						<li><a href="#!" onclick="window.location.reload();" class="tooltipped" data-position="bottom" data-tooltip="Refresh"><i class="material-icons left">refresh</i>Refresh</a></li>
						<li class="no-padding">
							<ul class="collapsible collapsible-accordion">
								<li>
									<a class="collapsible-header"><i class="material-icons left" style="margin-left: 16px;">settings</i>Settings<i class="material-icons right">arrow_drop_down</i></a>
									<div class="collapsible-body">
										<ul>
											<li><a href="#!" class="display-expand"><i class="material-icons left">swap_horiz</i>Expand display</a></li>
											<li><a href="#modal-connect" class="modal-trigger"><i class="material-icons left">settings_ethernet</i>Connection</a></li>
											<li><a href="#!">Other</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</header>

	<main class="grey lighten-4 grey-text text-darken-3">
		<div id="variable-container" class="container">
			<div class="row">
				<div class="col s12">

					<?php if(!isset($_GET['module'])||(isset($_GET['module'])&&empty($_GET['module']))):?>

					<h1>Modules</h1>
					<div class="row">
						<div class="col s6 m4 l3">
							<div class="card-panel hoverable">
								<p class="flow-text center-align">
									<a href="?module=dsh">
										<i class="material-icons">dashboard</i>
										<br><span class="truncate">Dashboard</span>
									</a>
								</p>
							</div>
						</div>
						<div class="col s6 m4 l3">
							<div class="card-panel hoverable">
								<p class="flow-text center-align">
									<a href="?module=hyp">
										<i class="material-icons">cloud</i>
										<br><span class="truncate">Hypervisor</span>
									</a>
								</p>
							</div>
						</div>
						<div class="col s6 m4 l3">
							<div class="card-panel hoverable">
								<p class="flow-text center-align">
									<a href="?module=vms">
										<i class="material-icons">computer</i>
										<br><span class="truncate">Virtual Machines</span>
									</a>
								</p>
							</div>
						</div>
						<div class="col s6 m4 l3">
							<div class="card-panel hoverable">
								<p class="flow-text center-align">
									<a href="?module=vns">
										<i class="material-icons">router</i>
										<br><span class="truncate">Virtual Networks</span>
									</a>
								</p>
							</div>
						</div>
						<div class="col s6 m4 l3">
							<div class="card-panel hoverable">
								<p class="flow-text center-align">
									<a href="?module=vst">
										<i class="material-icons">storage</i>
										<br><span class="truncate">Virtual Storage</span>
									</a>
								</p>
							</div>
						</div>
					</div>

					<?php endif;?>

					<?php if(isset($_GET['module'])&&!empty($_GET['module'])){switch($t0){case 'dsh':require_once __DIR__.'/modules/dashboard.php';break;case 'hyp':require_once __DIR__.'/modules/hypervisor.php';break;case 'vmi':require_once __DIR__.'/modules/machine.php';break;case 'vms':require_once __DIR__.'/modules/machines.php';break;case 'vns':require_once __DIR__.'/modules/networks.php';break;case 'vni':require_once __DIR__.'/modules/network.php';break;case 'vst':require_once __DIR__.'/modules/storage.php';break;default:require_once __DIR__.'/modules/invalid.php';break;}}?>

					<?php if(isset($_GET['module'])):?>

					<div class="row">
						<div class="col s12">
							<a href="javascript:history.back();"><i class="material-icons left">arrow_back</i> Back</a>
						</div>
					</div>

					<?php endif;?>

				</div>
			</div>
		</div>
	</main>

	<footer class="page-footer grey darken-3">
		<div class="container">
			<div class="row">
				</div>
			</div>
		</div>
	</footer>

	<!-- Modals -->
	<div id="modal-help" class="modal modal-fixed-footer">
		<div class="modal-content grey-text text-darken-3">
			<h4>Command list</h4>
			<pre><?php $j1->virsh_passthru('help');?></pre>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
		</div>
	</div>
	<div id="modal-connect" class="modal">
		<div class="modal-content grey-text text-darken-3">
			<h4 style="margin-bottom: 0;">Connection</h4>
			<div class="row">
				<form class="col s12" id="connectForm">
					<p class="flow-text">Select a connection mode:</p>
					<div class="row">
						<div class="col s4">
							<p>
								<input class="with-gap" name="connect-mode" type="radio" id="connect-mode-system" checked />
								<label for="connect-mode-system">System</label>
							</p>
						</div>
						<div class="col s4">
							<p>
								<input class="with-gap" name="connect-mode" type="radio" id="connect-mode-session" />
								<label for="connect-mode-session">Session</label>
							</p>
						</div>
						<div class="col s4">
							<p>
								<input class="with-gap" name="connect-mode" type="radio" id="connect-mode-ssh" />
								<label for="connect-mode-ssh">SSH</label>
							</p>
						</div>
					</div>
					<div id="connect-ssh" class="row" style="display: none;">
						<div class="input-field col s6">
							<input id="connect-user" type="text" class="validate" autofocus required>
							<label for="connect-user">User</label>
						</div>
						<div class="input-field col s6">
							<input id="connect-host" type="text" class="validate" required>
							<label for="connect-host">Host</label>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat red-text text-accent-3">Cancel</a>
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat green-text text-accent-3">Connect</a>
		</div>
	</div>

	<!-- Import jQuery before materialize.js -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

	<!-- App JS -->
	<script type="text/javascript" src="<?php echo '//'.$_SERVER['HTTP_HOST'].'/libvirt.js';?>"></script>
	<script type="text/javascript" src="<?php echo '//'.$_SERVER['HTTP_HOST'].'/libvirt.ui.js';?>"></script>

	<!-- Connection -->
	<?php if(!isset($_SESSION['connected'])||(isset($_SESSION['connected'])&&$_SESSION['connected']!==true)){$j1->virsh_connect();}?>

	<!-- Notifications -->
	<?php if(isset($_SESSION['notifications'])&&is_object($_SESSION['notifications'])){if(count($_SESSION['notifications']->$x2)>0){$j1->create_notification($_SESSION['notifications']->$x2);}if(count($_SESSION['notifications']->$h3)>0){$j1->create_error_notification($_SESSION['notifications']->$h3);}}?>

	<!--
	<?php echo 'Debug: '.print_r($_SERVER,true);?>
	-->

</body>
</html>