<?php session_start(['name'=>'libvirt-session','cookie_httponly'=>'1','use_strict_mode'=>'1']);if(session_status()===PHP_SESSION_ACTIVE){session_regenerate_id(false);}if(!isset($_SESSION['notifications'])){$_SESSION['notifications']=new stdClass;$_SESSION['notifications']->$a0=[];$_SESSION['notifications']->$o1=[];}require_once __DIR__.'/libs/PpmImageReader.php';function dom2xml($p2){foreach($p2->$f3 as $f4){if($f4->hasChildNodes()){dom2xml($f4);}else{if($p2->hasAttributes()&&strlen($p2->$k5)){$p2->setAttribute("nodeValue",$f4->$s6);$f4->$k5="";}}}}function xml2json($j7,$t8=false,$b9=false){$x10=new DOMDocument();$x10->loadXML($j7);dom2xml($x10);$t11=simplexml_load_string($x10->saveXML());if($b9===true){$w12=str_replace(['@','"\n"'],['','""'],json_encode($t11,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));}else{$w12=str_replace(['@','"\n"'],['','""'],json_encode($t11,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES));}$p13=json_decode($w12,true);return($t8===true?$p13:$w12);}function get_loading_time(){return number_format(microtime(true)-$_SERVER["REQUEST_TIME_FLOAT"],4);}function secure_password($u14){if($u14){return base64_encode(str_rot13($u14));}return false;}function restore_password($u14){if($u14){return base64_decode(str_rot13($u14));}return false;}function ppm_to_png($d15,$c16=100,$r17=null){$h18=new PpmImageReader();if($c16===100){$h19=0;}else{$h19=intval(($c16/100*10));}if($h18->canRead($d15)===true){$y20=$h18->read($d15);if(!is_null($r17)){imagepng($y20[1],$r17,$h19);}else{return $y20;}}return false;}function ppm_to_jpg($d15,$c16=100,$r17=null){$h18=new PpmImageReader();if($h18->canRead($d15)===true){$y20=$h18->read($d15);if(!is_null($r17)){imagejpeg($y20[1],$r17,$c16);}else{return $y20;}}return false;}function virsh_shell_exec($c21){$i22='virsh';$b23=escapeshellcmd($i22.' '.$c21);$o24='2>&1';return trim(shell_exec($b23.' '.$o24));}function virsh_exec($c21,&$r17,&$h25){$i22='virsh';$b23=escapeshellcmd($i22.' '.$c21);$o24='2>&1';exec($b23.' '.$o24,$r17,$h25);}function virsh_exec_notify($c21,&$r17,&$h25){$i22='virsh';$b23=escapeshellcmd($i22.' '.$c21);$o24='2>&1';exec($b23.' '.$o24,$r17,$h25);foreach($r17 as $u26){if(!empty($u26)){if(strpos($u26,'error:')!==false){add_notification($u26,true);}else{add_notification($u26);}}}}function virsh_passthru($c21,&$h25=null){$i22='virsh';$b23=escapeshellcmd($i22.' '.$c21);$o24='2>&1';passthru($b23.' '.$o24,$h25);}function virsh_connect($o27='qemu:///system'){$r17=null;$h25=null;virsh_exec('connect --name '.$o27,$r17,$h25);if($h25!==0){$_SESSION['connected']=false;add_notification('Не могу соединится с сервером.',true);}else{$_SESSION['connected']=true;add_notification('Соединение с сервером');add_notification(Соединение по ссылке:' . $uri);
	}
	return $_SESSION['connected'];
}

function add_notification($data, $error = false) {
	if ($error === false) {
		$add_status = array_push($_SESSION['notifications']->info, $data);
	}
	else {
		$add_status = array_push($_SESSION['notifications']->error, $data);
	}
	return $add_status;
}
function create_notification(&$data, $timeout = 4000) {
	if (!is_array($data)) {
		echo '<script type="text/javascript">';
		echo 'Materialize.toast("' . $v28 . '",' . $timeout . ',"rounded");';
		echo '</script>';
	}
	else {
		$key = 0;
		foreach ($data as $text) {
			$cleaned_text = trim($text);
			if (!empty($cleaned_text)) {
				echo '<script type="text/javascript">';
				echo 'Materialize.toast("' . $l29 . '",' . $timeout . ',"rounded");';
				echo '</script>';
			}
			unset($data[$key]);
			$key++;
		}
	}
}
function create_error_notification(&$data, $timeout = 4000) {
	if (!is_array($data)) {
		echo '<script type="text/javascript">';
		echo 'var toastContent=$(\'<span style="color: #f44336; font-weight: bold;">'.$v28.'</span>\');';echo 'Materialize.toast(toastContent, '.$e30.', "rounded");';echo '</script>';}else{$u31=0;foreach($v28 as $q32){$l29=trim($q32);if(!empty($l29)){echo '<script type="text/javascript">';echo 'var toastContent = $(\'<span style="color: #f44336; font-weight: bold;">'.$l29.'</span>\');';echo 'Materialize.toast(toastContent, '.$e30.', "rounded");';echo '</script>';}unset($v28[$u31]);$u31++;}}}function extract_data($u26,$x33){$u26=trim($u26);$v28=explode($x33,$u26);$v28=array_filter($v28);return $v28;}if(isset($_GET['module'])&&!empty($_GET['module'])){$_SESSION['module']=htmlentities(strip_tags(filter_var($_GET['module'],FILTER_SANITIZE_STRING)));}if(isset($_GET['action'])&&!empty($_GET['action'])){$_SESSION['action']=htmlentities(strip_tags(filter_var($_GET['action'],FILTER_SANITIZE_STRING)));}if(isset($_GET['name'])&&!empty($_GET['name'])){$_SESSION['vm_name']=htmlentities(strip_tags(filter_var($_GET['name'],FILTER_SANITIZE_STRING)));}function create_table_generic_rows($z34,$x33=' ',$j35=0,$t36=''){$j37=2;$i38=0;$r39=0;$u40=[];foreach($z34 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$r39++;echo '<tr>'.PHP_EOL;$u40=extract_data($u26,$x33);foreach($u40 as $v28){echo '<td>'.trim($v28).'</td>'.PHP_EOL;}echo '</tr>'.PHP_EOL;}}if(count($u40)===0){echo '<tr><td'.($j35>0?' colspan="'.$j35.'"':'').($t36!==''?' class="'.$t36.'"':'').'>No data</td></td>'.PHP_EOL;}}function create_table_active_ips_rows($z34,$x33=' ',$j35=0,$t36=''){$j37=2;$i38=0;$j41=0;$r39=0;$u40=[];$o42=2;$c43=4;$h44=5;foreach($z34 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$r39++;echo '<tr>'.PHP_EOL;$u40=extract_data($u26,$x33);foreach($u40 as $v28){$j41++;$k45=trim($v28);if($j41===$o42){if($k45!=='-'||!empty($k45)){echo '<td><a href="?module=vni&mac='.$k45.'">'.$k45.'</a></td>'.PHP_EOL;}else{echo '<td>'.$k45.'</td>'.PHP_EOL;}}elseif($j41===$c43){echo '<td>'.$k45.'</td>'.PHP_EOL;}elseif($j41===$h44){if($k45!=='-'){$u46=explode(' ',$k45);$i47=$u46[0];$h48='';if(count($u46)>1){$h48=$u46[1];}if(!empty($h48)){echo '<td>'.$i47.'</td>'.PHP_EOL;echo '<td>'.$h48.'</td>'.PHP_EOL;}else{echo '<td>'.$i47.'</td>'.PHP_EOL;}}else{echo '<td>'.$k45.'</td>'.PHP_EOL;}}else{echo '<td>'.$k45.'</td>'.PHP_EOL;}}echo '</tr>'.PHP_EOL;$j41=0;}if(count($u40)===0){echo '<tr><td'.($j35>0?' colspan="'.$j35.'"':'').($t36!==''?' class="'.$t36.'"':'').'>No data</td></td>'.PHP_EOL;}}function create_table_active_vms_rows($z34,$x33=' ',$j35=0,$t36=''){$j37=2;$i38=0;$j41=0;$r39=0;$u40=[];$r49=1;$e50=2;$u51=3;$u52=0;foreach($z34 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$r39++;echo '<tr>'.PHP_EOL;$u40=extract_data($u26,$x33);foreach($u40 as $v28){$j41++;$k45=trim($v28);if($j41===$r49){if($k45!=='-'){$u52=(int)$k45;}}if($j41===$e50){$b53=$k45;echo '<td><a href="?module=vmi&name='.$k45.'">'.$k45.'</a></td>'.PHP_EOL;}elseif($j41===$u51){echo '<td>'.$k45.'&nbsp;'.PHP_EOL;if($k45==='shut off'){echo '<a href="?module='.$_SESSION['module'].'&action=start&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Start"><i class="material-icons">play_arrow</i></a>'.PHP_EOL;}else{echo '<a href="?module='.$_SESSION['module'].'&action=stop&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Stop"><i class="material-icons">stop</i></a>'.PHP_EOL;if($k45==='paused'){echo '<a href="?module='.$_SESSION['module'].'&action=resume&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Resume"><i class="material-icons">play_arrow</i></a>'.PHP_EOL;}else{echo '<a href="?module='.$_SESSION['module'].'&action=suspend&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Suspend"><i class="material-icons">pause</i></a>'.PHP_EOL;}echo '<a href="?module='.$_SESSION['module'].'&action=reboot&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Reboot"><i class="material-icons">replay</i></a>'.PHP_EOL;}echo '</td>'.PHP_EOL;echo '<td>'.PHP_EOL;create_vm_screenshots($b53);echo '</td>'.PHP_EOL;echo '<td>'.PHP_EOL;echo '<a href="?module='.$_SESSION['module'].'&action=view&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="View"><i class="material-icons">personal_video</i></a>'.PHP_EOL;echo '</td>'.PHP_EOL;}else{echo '<td>'.$k45.'</td>'.PHP_EOL;}}echo '</tr>'.PHP_EOL;$j41=0;}}if(count($u40)===0){echo '<tr><td'.($j35>0?' colspan="'.$j35.'"':'').($t36!==''?' class="'.$t36.'"':'').'>No data</td></td>'.PHP_EOL;}}function create_table_vms_rows($z34,$x33=' ',$j35=0,$t36=''){$j37=2;$i38=0;$j41=0;$r39=0;$u40=[];$r49=1;$e50=2;$u51=3;$u52=0;foreach($z34 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$r39++;echo '<tr>'.PHP_EOL;$u40=extract_data($u26,$x33);foreach($u40 as $v28){$j41++;$k45=trim($v28);if($j41===$e50){$b53=$k45;echo '<td><a href="?module=vmi&name='.$k45.'">'.$k45.'</a></td>'.PHP_EOL;}elseif($j41===$u51){echo '<td>'.$k45.'&nbsp;'.PHP_EOL;if($k45==='shut off'){echo '<a href="?module='.$_SESSION['module'].'&action=start&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Start"><i class="material-icons">play_arrow</i></a>'.PHP_EOL;}else{echo '<a href="?module='.$_SESSION['module'].'&action=stop&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Stop"><i class="material-icons">stop</i></a>'.PHP_EOL;echo '<a href="?module='.$_SESSION['module'].'" class="tooltipped" data-position="bottom" data-tooltip="Refresh"><i class="material-icons">refresh</i></a>'.PHP_EOL;}echo '</td>'.PHP_EOL;echo '<td>'.PHP_EOL;echo '<a href="?module='.$_SESSION['module'].'&action=save&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Create snapshot"><i class="material-icons">save</i></a>'.PHP_EOL;echo '<a href="?module='.$_SESSION['module'].'&action=edit&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Edit"><i class="material-icons">edit</i></a>'.PHP_EOL;echo '<a href="?module='.$_SESSION['module'].'&action=del&name='.$b53.'" class="tooltipped" data-position="bottom" data-tooltip="Delete"><i class="material-icons">delete</i></a>'.PHP_EOL;echo '</td>'.PHP_EOL;}else{echo '<td>'.$k45.'</td>'.PHP_EOL;}}echo '</tr>'.PHP_EOL;$j41=0;}}if(count($u40)===0){echo '<tr><td'.($j35>0?' colspan="'.$j35.'"':'').($t36!==''?' class="'.$t36.'"':'').'>No data</td></td>'.PHP_EOL;}}function vm_is_active($b53){$f54=false;$b55=virsh_shell_exec('domstate '.$b53);if($b55==='running'||$b55==='paused'){$f54=true;}return $f54;}function create_vm_screenshots($b53){$h56='/tmp/'.$b53.'_screen.ppm';$w57='/tmp/'.$b53.'_screen.png';passthru(escapeshellcmd('virsh screenshot '.$b53.' --file '.$h56.' --screen 0').' 2>&1 >/dev/null');if(is_readable($h56)){ppm_to_png($h56,80,$w57);if(is_readable($w57)){echo '<img class="materialboxed" src="data:image/png;base64,'.base64_encode(file_get_contents($w57)).'" width="80" alt="'.$b53.' screenshot">';}}else{echo 'Could not read screenshot.';}}function parse_vm_stats($b53,$t58=false,$b9=false){$j37=1;$s59='';$r60='';$u40=[];$z61=[];virsh_exec('domstats --raw '.$b53,$s59,$r60);if($r60===0){$i38=0;$a62=0;foreach($s59 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$a62++;$p63=extract_data($u26,'.');array_push($z61,$p63[0]);}}$z61=array_unique($z61);array_merge($u40,$z61);$i38=0;$a62=0;foreach($s59 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$a62++;$a64=extract_data($u26,'.');$p63=extract_data($u26,'=');if(count($p63)===2){$j65=['name'=>$p63[0],'value'=>$p63[1]];$u40[$a64[0]][]=$j65;}}}if($t58===true){if($b9===true){$w66=json_encode($u40,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);}else{$w66=json_encode($u40,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES);}return $w66;}else{return $u40;}}return false;}function get_vm_cpu_stats($b53,$t58=false,$b9=false){if($j67=parse_vm_stats($b53)){$n68=[];foreach($j67['vcpu']as $r69){$n70=explode('.',$r69['name']);if(count($n70)===2){$c71=['name'=>$n70[1],'value'=>(is_numeric($r69['value'])?(int)$r69['value']:$r69['value'])];}else{$c71=['name'=>$r69['name'],'value'=>(is_numeric($r69['value'])?(int)$r69['value']:$r69['value'])];}array_push($n68,$c71);}if($t58===true){if($b9===true){$w66=json_encode($n68,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);}else{$w66=json_encode($n68,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES);}return $w66;}else{return $n68;}}return false;}function get_vm_mem_stats($b53,$t58=false,$b9=false){if($j67=parse_vm_stats($b53)){$b72=[];foreach($j67['balloon']as $v73){$p74=explode('.',$v73['name']);if(count($p74)===2){$b75=['name'=>$p74[1],'value'=>(is_numeric($v73['value'])?(int)$v73['value']:$v73['value'])];}else{$b75=['name'=>$v73['name'],'value'=>(is_numeric($v73['value'])?(int)$v73['value']:$v73['value'])];}array_push($b72,$b75);}if($t58===true){if($b9===true){$w66=json_encode($b72,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);}else{$w66=json_encode($b72,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES);}return $w66;}else{return $b72;}}return false;}function get_vm_net_stats($b53,$t58=false,$b9=false){if($j67=parse_vm_stats($b53)){$l76=[];foreach($j67['net']as $c77){$r78=explode('.',$c77['name']);if(count($r78)===2){$i79=['name'=>$r78[1],'value'=>(is_numeric($c77['value'])?(int)$c77['value']:$c77['value'])];}else{$i79=['name'=>$c77['name'],'value'=>(is_numeric($c77['value'])?(int)$c77['value']:$c77['value'])];}array_push($l76,$i79);}if($t58===true){if($b9===true){$w66=json_encode($l76,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);}else{$w66=json_encode($l76,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES);}return $w66;}else{return $l76;}}return false;}function get_vm_networks(){$r17=null;$h25=null;$j37=2;$i38=0;$u40=[];$z80=[];virsh_exec('net-list',$r17,$h25);foreach($r17 as $u26){$i38++;if($i38>$j37&&!empty($u26)){$u40=extract_data($u26,' ');array_push($z80,$u40[0]);}}return(count($z80)>0?$z80:false);}if(!isset($_SESSION['vm_networks'])||(isset($_SESSION['vm_networks'])&&!is_array($_SESSION['vm_networks']))){$_SESSION['vm_networks']=get_vm_networks();}if(isset($_SESSION)&&is_array($_SESSION)){echo '<!-- '.PHP_EOL;print_r($_SESSION);echo ' -->'.PHP_EOL;}$c81='libVirt Web';if(isset($_SESSION['module'])&&!empty($_SESSION['module'])){switch($_SESSION['module']){case 'dsh':$r82='Dashboard';break;case 'hyp':$r82='Hypervisor';break;case 'vdi':$r82='Volume Details';break;case 'vmi':$r82='VM Details';break;case 'vms':$r82='Virtual Machines';break;case 'vni':$r82='Network Details';break;case 'vns':$r82='Virtual Networks';break;case 'vst':$r82='Virtual Storage';break;case 'hlp':$r82='Help';break;default:$r82='';break;}$r82.=(!empty($r82)?' &ndash; '.$c81:'');}else{$r82=$c81;}if(isset($_SESSION['action'])&&!empty($_SESSION['action'])){$t83='';switch($_SESSION['action']){case 'reboot':$i84='reboot '.$_SESSION['vm_name'];virsh_exec_notify($i84,$t83,$o85);break;case 'resume':$i84='resume '.$_SESSION['vm_name'];virsh_exec_notify($i84,$t83,$o85);break;case 'save':$i84='snapshot-create-as --domain '.$_SESSION['vm_name'];$i84.=' --name "'.(vm_is_active($_SESSION['vm_name'])?'live':'offline').'-snapshot-'.date("dmYHis").'"';$i84.=' --description "'.(vm_is_active($_SESSION['vm_name'])?'Live':'Offline').' snapshot taken on '.date("d/m/Y H:i:s").'"';virsh_exec_notify($i84,$t83,$o85);if($o85!==0){$i84='snapshot-create-as --domain '.$_SESSION['vm_name'];$i84.=' --name "'.(vm_is_active($_SESSION['vm_name'])?'live':'offline').'-disk-only-snapshot-'.date("dmYHis").'"';$i84.=' --description "'.(vm_is_active($_SESSION['vm_name'])?'Live':'Offline').' disk-only snapshot taken on '.date("d/m/Y H:i:s").'"';$i84.=' --quiesce';$i84.=' --disk-only';virsh_exec_notify($i84,$t83,$o85);}break;case 'del':$i84='undefine --domain '.$_SESSION['vm_name'];break;case 'start':$i84='start '.$_SESSION['vm_name'];virsh_exec_notify($i84,$t83,$o85);break;case 'stop':$i84='shutdown '.$_SESSION['vm_name'];virsh_exec_notify($i84,$t83,$o85);break;case 'suspend':$i84='suspend '.$_SESSION['vm_name'];virsh_exec_notify($i84,$t83,$o85);break;case 'view':$i84='virt-viewer -v -w '.escapeshellarg($_SESSION['vm_name']).' &';exec($i84,$t83,$o85);break;default:break;}}if($_SERVER['REQUEST_METHOD']==='POST'){if(isset($_FILES['upload_file'])){echo print_r($_FILES['upload_file'],true);if(move_uploaded_file($_FILES['upload_file']['tmp_name'],sys_get_temp_dir().'/'.$_FILES['upload_file']['name'])){echo $_FILES['upload_file']['name']." OK";}else{echo $_FILES['upload_file']['name']." KO";}}else{echo print_r($_FILES['upload_file'],true);echo 'No files uploaded...'.PHP_EOL;}exit;}function send_json($v28,$q86=false){header('Content-Type: application/json');if($q86===true){echo json_encode($v28,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES);}else{echo json_encode($v28);}}if(isset($_REQUEST['module'])&&$_REQUEST['module']==='ajx'){if(isset($_REQUEST['data'])&&!empty($_REQUEST['data'])){$h87=htmlentities(strip_tags(filter_var($_REQUEST['data'],FILTER_SANITIZE_STRING)));switch($h87){case 'cpu':$s59=virsh_shell_exec('nodecpustats');break;case 'mem':$s59=virsh_shell_exec('nodememstats');break;case 'node':$s59=virsh_shell_exec('nodeinfo');break;case 'vhostcpu':if(vm_is_active($_SESSION['vm_name'])){$s59=virsh_shell_exec('cpu-stats '.$_SESSION['vm_name']);}else{$s59='VM is not running.';}break;case 'vcpu':if(vm_is_active($_SESSION['vm_name'])){$s59=print_r(get_vm_cpu_stats($_SESSION['vm_name']),true);}else{$s59='VM is not running.'.PHP_EOL;$s59.=print_r(get_vm_cpu_stats($_SESSION['vm_name']),true);}break;case 'vmem':if(vm_is_active($_SESSION['vm_name'])){$s59=print_r(get_vm_mem_stats($_SESSION['vm_name']),true);}else{$s59='VM is not running.'.PHP_EOL;$s59.=print_r(get_vm_mem_stats($_SESSION['vm_name']),true);}break;case 'vnet':if(vm_is_active($_SESSION['vm_name'])){$s59=print_r(get_vm_net_stats($_SESSION['vm_name']),true);}else{$s59='VM is not running.';}break;case 'vhost':$s59=virsh_shell_exec('domstats --raw '.$_SESSION['vm_name']);break;}$l88=new stdClass;$l88->$r89='';$l88->$r89.=$s59;$l88->$t90=(!is_null($s59)?true:false);send_json($l88,true);exit;}}?>
<!DOCTYPE html>
<html>
<head>
	<!-- Import Google Icon Font -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- Import materialize.css -->
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection"/>

	<!-- Let browser know website is optimized for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<title><?php echo $r82;?></title>

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
					<a href="./" class="brand-logo"><i class="material-icons">developer_board</i>libVirt Web</a>
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="?module=dsh" class="tooltipped" data-position="bottom" data-tooltip="Show dashboard"><i class="material-icons left">dashboard</i>Dashboard</a></li>
						<li><a href="./" class="tooltipped" data-position="bottom" data-tooltip="Show modules"><i class="material-icons left">apps</i>Modules</a></li>
						<li><a href="#modal-help" class="tooltipped modal-trigger" data-position="bottom" data-html="true" data-tooltip="Display &lt;strong&gt;virsh&lt;/strong&gt; commands"><i class="material-icons left">help_outline</i>Help</a></li>
						<li><a href="#!" onclick="window.location.reload();" class="tooltipped" data-position="bottom" data-tooltip="Refresh"><i class="material-icons left">refresh</i>Refresh</a></li>
						<li><a href="#!" class="dropdown-button" data-activates="settings-dropdown" data-hover="false" data-alignment="right" data-belowOrigin="true"><i class="material-icons left">settings</i>Settings<i class="material-icons right">arrow_drop_down</i></a></li>
					</ul>
					<ul id="settings-dropdown" class="dropdown-content">
						<li><a href="#!" class="display-expand"><i class="material-icons left">swap_horiz</i>Expand display</a></li>
						<li><a href="#!"><i class="material-icons left">settings_ethernet</i>Connection</a></li>
						<li class="divider"></li>
						<li><a href="#!">Other</a></li>
					</ul>
					<ul class="side-nav" id="mobile-demo">
						<li><a href="?module=dsh" class="tooltipped" data-position="bottom" data-tooltip="Show dashboard"><i class="material-icons left">dashboard</i>Dashboard</a></li>
						<li><a href="./" class="tooltipped" data-position="bottom" data-tooltip="Show modules"><i class="material-icons left">apps</i>Modules</a></li>
						<li><a href="?module=hlp" title="Display 'virsh' commands"><i class="material-icons left">help_outline</i>Help</a></li>
						<li><a href="#!" onclick="window.location.reload();" class="tooltipped" data-position="bottom" data-tooltip="Refresh"><i class="material-icons left">refresh</i>Refresh</a></li>
						<li class="no-padding">
							<ul class="collapsible collapsible-accordion">
								<li>
									<a class="collapsible-header"><i class="material-icons left" style="margin-left: 16px;">settings</i>Settings<i class="material-icons right">arrow_drop_down</i></a>
									<div class="collapsible-body">
										<ul>
											<li><a href="#!" class="display-expand"><i class="material-icons left">swap_horiz</i>Expand display</a></li>
											<li><a href="#!"><i class="material-icons left">settings_ethernet</i>Connection</a></li>
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
						<div class="col s6 m4 l3">
							<div class="card-panel hoverable">
								<p class="flow-text center-align">
									<a href="?module=hlp">
										<i class="material-icons">help_outline</i>
										<br><span class="truncate">Help</span>
									</a>
								</p>
							</div>
						</div>
					</div>

					<?php endif;?>

					<?php if(isset($_GET['module'])&&!empty($_GET['module'])){switch($_SESSION['module']){case 'dsh':$g91='';$i92='';exec('virsh list',$g91,$p93);exec('virsh net-dhcp-leases default',$i92,$z94);?>

					<div class="row">
						<div class="col s6">
							<h3>CPU</h3>
							<pre id="cpu-stats"><?php virsh_passthru('nodecpustats');?></pre>
						</div>
						<div class="col s6">
							<h3>Memory</h3>
							<pre id="mem-stats"><?php virsh_passthru('nodememstats');?></pre>
						</div>
						<div class="col s12">
							<blockquote>The data displayed above will be converted into realtime graph soon.</blockquote>
						</div>
						<div class="col s6">
							<h3>Node</h3>
							<pre id="node-info"><?php virsh_passthru('nodeinfo');?></pre>
						</div>
						<div class="col s6">
							<h3>Map</h3>
							<pre><?php virsh_passthru('nodecpumap');?></pre>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<h3>Running VM's</h3>
							<table class="striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Name</th>
										<th>State</th>
										<th>Screenshot</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($g91)&&!empty($g91))create_table_active_vms_rows($g91,'  ',5,'center-align');?>

								</tbody>
								<tfoot>
									<tr>
										<td colspan="3">Max instances: <?php virsh_passthru('maxvcpus');?></td>
									</tr>
								</tfoot>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($g91);var_dump($p93);?></pre> -->
							<?php if(isset($_SESSION['action'])&&!empty($_SESSION['action'])):?>
							<h6>Raw data</h6>
							<pre><?php if(isset($t83)){print_r($t83);}if(isset($o85)){var_dump($o85);}?></pre>
							<?php endif;?>
						</div>
						<div class="col s12">
							<h3>Active IP's</h3>
							<table class="striped">
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

								<?php if(isset($i92)&&!empty($i92))create_table_active_ips_rows($i92,'  ',6,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($i92);var_dump($z94);?></pre> -->
						</div>
					</div>

								<?php break;case 'hyp':?>

					<div class="row">
						<div class="col s12">
							<h1>Hypervisor</h1>
							<div class="row">
								<div class="col s6 m4 l3">
									<div class="card-panel hoverable">
										<p class="flow-text center-align">
											<a href="<?php echo '?module='.$_SESSION['module'].'&do=view';?>">
												<i class="material-icons">developer_board</i>
												<br><span class="truncate">System Info</span>
											</a>
										</p>
									</div>
								</div>
								<div class="col s6 m4 l3">
									<div class="card-panel hoverable">
										<p class="flow-text center-align">
											<a href="<?php echo '?module='.$_SESSION['module'].'&do=create&type=vm';?>">
												<i class="material-icons">computer</i>
												<br><span class="truncate">Create VM</span>
											</a>
										</p>
									</div>
								</div>
								<div class="col s6 m4 l3">
									<div class="card-panel hoverable">
										<p class="flow-text center-align">
											<a href="<?php echo '?module='.$_SESSION['module'].'&do=create&type=net';?>">
												<i class="material-icons">router</i>
												<br><span class="truncate">Create Network</span>
											</a>
										</p>
									</div>
								</div>
								<div class="col s6 m4 l3">
									<div class="card-panel hoverable">
										<p class="flow-text center-align">
											<a href="#modal-upload" class="modal-trigger">
												<i class="material-icons">storage</i>
												<br><span class="truncate">Upload Images</span>
											</a>
										</p>
									</div>
								</div>
							</div>
							<!-- <div class="row">
								<div class="col s12">
									<h5>Parsed data</h5>
									<pre style="height: 300px;"><?php print_r(xml2json(virsh_shell_exec('sysinfo'),false,true));?></pre>
									<h6>Raw data</h6>
									<pre style="height: 300px;"><?php echo htmlentities(virsh_shell_exec('sysinfo'));?></pre>
								</div>
							</div> -->
						</div>
					</div>

								<?php break;case 'vmi':?>

					<div class="row">
						<div class="col s12">
							<h1>VM Details</h1>
							<div class="row">
								<div class="col s7">
									<h3>Summary</h3>
									<pre><?php virsh_passthru('dominfo '.$_SESSION['vm_name']);?></pre>
								</div>
								<div class="col s5">
									<h3>Hypervisor</h3>
									<pre id="vhostcpu-stats" style="height: 300px;"><?php if(vm_is_active($_SESSION['vm_name'])){virsh_passthru('cpu-stats '.$_SESSION['vm_name']);}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
								</div>
							</div>
							<h3>Statistics</h3>
							<div class="row">
								<div class="col s4">
									<h5>CPU</h5>
									<pre id="vcpu-stats" style="height: 300px;"><?php if(vm_is_active($_SESSION['vm_name'])){print_r(get_vm_cpu_stats($_SESSION['vm_name']));}else{echo 'VM is not running.'.PHP_EOL;print_r(get_vm_cpu_stats($_SESSION['vm_name']));}?></pre>
								</div>
								<div class="col s4">
									<h5>Memory</h5>
									<pre id="vmem-stats" style="height: 300px;"><?php if(vm_is_active($_SESSION['vm_name'])){print_r(get_vm_mem_stats($_SESSION['vm_name']));}else{echo 'VM is not running.'.PHP_EOL;print_r(get_vm_mem_stats($_SESSION['vm_name']));}?></pre>
								</div>
								<div class="col s4">
									<h5>Network</h5>
									<pre id="vnet-stats" style="height: 300px;"><?php if(vm_is_active($_SESSION['vm_name'])){print_r(get_vm_net_stats($_SESSION['vm_name']));}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
								</div>
								<div class="col s12">
									<h5>Global</h5>
									<pre id="vhost-stats" style="height: 300px;"><?php virsh_passthru('domstats --raw '.$_SESSION['vm_name']);?></pre>
									<pre style="height: 300px;"><?php print_r(parse_vm_stats($_SESSION['vm_name']));?></pre>
								</div>
							</div>
							<h3>
								Virtual CPU's
								<i class="material-icons tooltipped light-blue-text text-darken-1" style="cursor: pointer;" data-position="right" data-tooltip="View CPU Stats" onclick="$('#modal-cpu-stats').modal('open');">info_outline</i>
							</h3>
							<pre><?php virsh_passthru('vcpucount '.$_SESSION['vm_name']);?></pre>
							<!-- <a href="#modal-cpu-stats" class="modal-trigger"><i class="material-icons left">info_outline</i>View CPU Stats</a> -->
							<div id="modal-cpu-stats" class="modal modal-fixed-footer">
								<div class="modal-content">
									<h4>CPU Stats</h4>
									<pre><?php virsh_passthru('vcpuinfo '.$_SESSION['vm_name']);?></pre>
								</div>
								<div class="modal-footer">
									<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
								</div>
							</div>
							<h3>Network Interfaces</h3>
							<pre><?php virsh_passthru('domiflist '.$_SESSION['vm_name']);?></pre>
							<h3>Network Addresses</h3>
							<pre><?php if($_SESSION['vm_name']==='ceph-admin'){virsh_passthru('domifaddr '.$_SESSION['vm_name'].' --interface vnet0');}else{echo 'Tested on "ceph-admin" only...'.PHP_EOL;}?></pre>
							<h3>Attached devices</h3>
							<pre><?php virsh_passthru('domblklist '.$_SESSION['vm_name']);?></pre>
							<h3>Snapshots</h3>
							<pre><?php virsh_passthru('snapshot-list '.$_SESSION['vm_name']);?></pre>
							<h3>Running Jobs</h3>
							<pre><?php if(vm_is_active($_SESSION['vm_name'])){virsh_passthru('domjobinfo '.$_SESSION['vm_name']);}else{echo 'VM is not running.'.PHP_EOL;}?></pre>
							<!-- <h1>domtime</h1>
							<pre><?php ?></pre> -->
							<!-- <h1>domfsinfo</h1>
							<pre><?php ?></pre> -->
							<!-- <h1>domhostname</h1>
							<pre><?php ?></pre> -->
						</div>
					</div>

								<?php break;case 'vms':$g91='';$i92='';exec('virsh list --all',$g91,$p93);exec('virsh net-dhcp-leases default',$i92,$z94);?>

					<div class="row">
						<div class="col s12">
							<h1>Virtual Machines</h1>
							<table class="striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Name</th>
										<th>State</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($g91)&&!empty($g91))create_table_vms_rows($g91,'  ',4,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($g91);var_dump($p93);?></pre> -->
							<?php if(isset($_SESSION['action'],$t83,$o85)&&!empty($t83)):?>
							<h6>Raw data</h6>
							<pre><?php print_r($t83);var_dump($o85);?></pre>
							<?php endif;?>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<h1>Virtual IP Addresses</h1>
							<table class="striped">
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

								<?php if(isset($i92)&&!empty($i92))create_table_active_ips_rows($i92,'  ',6,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($i92);var_dump($z94);?></pre> -->
						</div>
					</div>

								<?php break;case 'vns':$f95='';$i92='';$v96='';exec('virsh net-list',$f95,$g97);exec('virsh net-dhcp-leases default',$i92,$z94);exec('virsh nwfilter-list',$v96,$i98);?>

					<div class="row">
						<div class="col s12">
							<h1>Virtual Networks</h1>
							<table class="striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>State</th>
										<th>Autostart</th>
										<th>Persistent</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($f95)&&!empty($f95))create_table_generic_rows($f95,'  ',4,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($f95);var_dump($g97);?></pre> -->
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<h1>Virtual IP Addresses</h1>
							<table class="striped">
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

								<?php if(isset($i92)&&!empty($i92))create_table_active_ips_rows($i92,'  ',6,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($i92);var_dump($z94);?></pre> -->
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<h1>Virtual Network Filters</h1>
							<table class="striped">
								<thead>
									<tr>
										<th>UUID</th>
										<th>Name</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($v96)&&!empty($v96))create_table_generic_rows($v96,'  ',2,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($v96);var_dump($i98);?></pre> -->
						</div>
					</div>

								<?php break;case 'vni':$i92='';exec('virsh net-dhcp-leases default',$i92,$z94);?>

					<div class="row">
						<div class="col s12">
							<h1>Virtual IP Addresses</h1>
							<table class="striped">
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

								<?php if(isset($i92)&&!empty($i92))create_table_active_ips_rows($i92,'  ',6,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($i92);var_dump($z94);?></pre> -->
						</div>
					</div>

								<?php break;case 'vdi':$f99='';exec('virsh vol-list default',$f99,$m100);?>

					<div class="row">
						<div class="col s12">
							<h1>Volume Details</h1>
							<table class="striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Path</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($f99)&&!empty($f99))create_table_generic_rows($f99,' ',2,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($f99);var_dump($m100);?></pre> -->
						</div>
					</div>

								<?php break;case 'vst':$d101='';$f99='';exec('virsh pool-list',$d101,$x102);exec('virsh vol-list default',$f99,$m100);?>

					<div class="row">
						<div class="col s12">
							<h1>Virtual Storage Pools</h1>
							<table class="striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>State</th>
										<th>Autostart</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($d101)&&!empty($d101))create_table_generic_rows($d101,'  ',3,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($d101);var_dump($x102);?></pre> -->
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<h1>Virtual Volumes</h1>
							<table class="striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Path</th>
									</tr>
								</thead>
								<tbody>

								<?php if(isset($f99)&&!empty($f99))create_table_generic_rows($f99,' ',2,'center-align');?>

								</tbody>
							</table>
							<!-- <h6>Raw data</h6>
							<pre><?php print_r($f99);var_dump($m100);?></pre> -->
						</div>
					</div>

								<?php break;case 'hlp':?>

					<div class="row">
						<div class="col s12">
							<h1>Command list</h1>
							<pre><?php virsh_passthru('help');?></pre>
						</div>
					</div>

								<?php break;default:?>

					<div class="row">
						<div class="col s12">
							<h1>Invalid module</h1>
						</div>
					</div>

								<?php break;}}?>

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
				<div class="col l6 s12">
					<h5 class="white-text">libVirt Web</h5>
					<p class="grey-text text-lighten-4">A simple web interface based on <a href="https://libvirt.org/" rel="nofollow noopener noreferrer" target="_blank">libVirt</a>.</p>
					<small class="grey-text text-lighten-4"><?php echo 'Generated in '.get_loading_time().' seconds';?></small>
				</div>
				<div class="col l3 offset-l3 s12">
					<h5 class="white-text">Links</h5>
					<ul>
						<li><a class="grey-text text-lighten-3" href="https://github.com/Jiab77/libvirt-web" rel="nofollow noopener noreferrer" target="_blank">Project</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				<?php echo '&copy; '.date("Y").' &ndash; <a href="https://github.com/jiab77" rel="nofollow noopener noreferrer" target="_blank">Jiab77</a>';?>
				<!-- <a class="grey-text text-lighten-4 right" href="https://gist.github.com/jiab77" rel="nofollow noopener noreferrer" target="_blank">My gists</a> -->
			</div>
		</div>
	</footer>

	<!-- Modals -->
	<div id="modal-help" class="modal modal-fixed-footer">
		<div class="modal-content grey-text text-darken-3">
			<h4>Command list</h4>
			<pre><?php virsh_passthru('help');?></pre>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
		</div>
	</div>
	<div id="modal-upload" class="modal modal-fixed-footer">
		<div class="modal-content grey-text text-darken-3">
			<h4>Upload Files</h4>
			<div class="row">
				<div class="col s12">
					<!-- <form action="<?php echo htmlentities(strip_tags((isset($_SERVER['HTTPS'])?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));?>"> -->
					<form id="uploadForm">
						<div class="file-field input-field">
							<div class="btn">
								<span>File</span>
								<input type="file" id="uploadFiles" onchange="updateSize();" multiple>
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text" placeholder="Upload one or more files">
							</div>
						</div>
						<div id="uploadProgress" class="progress" style="display: none;">
							<div id="progressValue" class="determinate" style="width: 0%"></div>
						</div>
						<p id="uploadSize" style="display: none;">
							Total: <span id="fileNum"></span><br>
							Size: <span id="fileSize"></span><br>
							Status: <span id="uploadStatus"></span>
						</p>
					</form>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
		</div>
	</div>

	<!-- Import jQuery before materialize.js -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

	<!-- App JS -->
	<script type="text/javascript" src="libvirt.js"></script>
	<script type="text/javascript" src="libvirt.ui.js"></script>

	<!-- Connection -->
	<?php if(!isset($_SESSION['connected'])||(isset($_SESSION['connected'])&&$_SESSION['connected']!==true)){virsh_connect();}?>

	<!-- Notifications -->
	<?php if(isset($_SESSION['notifications'])&&is_object($_SESSION['notifications'])){if(count($_SESSION['notifications']->$a0)>0){create_notification($_SESSION['notifications']->$a0);}if(count($_SESSION['notifications']->$o1)>0){create_error_notification($_SESSION['notifications']->$o1);}}?>

</body>
</html>