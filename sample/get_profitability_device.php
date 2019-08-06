<?php
$devices = array(
	'nvidia-gtx-1080-ti' => '6e88ab8b-7081-4170-84b5-a36686ec98fe',
	'nvidia-gtx-1070' => '5c76b698-a2d9-445c-aad4-38964dd35421',
	'nvidia-gtx-1060-6gb' => '869da26b-6e22-4819-8996-a19acfb9ec0d',
);

include('nh2.php');

$live_data = false; // change to false for read from cache file

$nh = new NH($live_data);
$nh->cache = false;


$key_is = 'algorithm';
$algos = $nh->get_algos($key_is);

foreach($devices as $device_name => $device_id):
	$data = $nh->get_device_speed($device_id);
	$hashrate = $data['speeds'];

	$speeds = json_decode($hashrate, true);
	foreach ($speeds as $akey => $avalue):
		if (isset($algos[$akey])):
			$algo_id = $algos[$akey]['order'];
			$n_data[$device_name][$algo_id] = $avalue;
		endif;
	endforeach;
	$j_data[$device_name] = json_encode($n_data[$device_name]);
	echo '<div><div style="font-weight:bold;">'.$device_name.'</div><textarea style="width:480px; height:120px;">'.$j_data[$device_name].'</textarea></div>';
endforeach;

/*
check_array($j_data);
check_array($n_data);
*/

?>
