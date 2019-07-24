<?php
include('nh2.php');

$nh = new NH();

$stats = $nh->get_stats_global();
$algos = $nh->get_algos();

foreach ($stats as $key => $value):
	$data[$key] = $value;
	
	$data[$key]['price_diff'] = number_format((($value['price'] - $value['24h_price'])/$value['24h_price'])*100, 2);
	$data[$key]['speed_diff'] = number_format((($value['speed'] - $value['24h_speed'])/$value['24h_speed'])*100, 2);
	$data[$key]['algo_name'] = $algos[$key]['title'];
	
	if ($value['price'] > $value['24h_price']):
		$data[$key]['price_tag'] = 'up';
	else:
		$data[$key]['price_tag'] = 'down';
	endif;
	if ($value['speed'] > $value['24h_speed']):
		$data[$key]['speed_tag'] = 'up';
	else:
		$data[$key]['speed_tag'] = 'down';
	endif;
endforeach;

// check_array($data);

$align = array('', 'c', 'r', 'c', 'r', 'r', 'r', 'r', 'r');
$format = array('', '', '', '', '', 'num_8', 'num_8', 'num_0', 'num_0');
$field = array('algo_name', 'price_tag', 'price_diff', 'speed_tag', 'speed_diff', 'price', '24h_price', 'speed', '24h_speed');
echo array2table($data, $field, $format, $align);
?>
