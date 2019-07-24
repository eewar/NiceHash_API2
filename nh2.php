<?php
class NH {
	function __construct() {
		$this->base_url = 'https://api2.nicehash.com/main/api/v2/';
		$this->cache_folder = 'nh2_cache/';
		!is_dir($this->cache_folder) mkdir($this->cache_folder);
	}

	
	function get($url, $online) {
		$filename = str_replace('/', '_', $url).'.json';
		$filename = $this->cache_folder.$filename;
		if ($online):
			$json = file_get_contents($this->base_url.$url);
			file_put_contents($filename, $json);
		else:
			if (is_file($filename)):
				$json = file_get_contents($filename);
			else:
				$json = file_get_contents($this->base_url.$url);
				file_put_contents($filename, $json);
			endif;
		endif;
		$array = json_decode($json, true);
		return $array;
	}

	
	function get_stats_global($online = false) {
		// return current and 24h stats
		// return key is algo_id
		$data = $this->get('public/stats/global/current', $online);
		$data_current = convert_v2k($data['algos'], 'a');
		
		$data = $this->get('public/stats/global/24h', $online);
		$data_24h = convert_v2k($data['algos'], 'a');
		
		foreach ($data_current as $key => $value):
			$stats_global[$value['a']] = array(
				'price' => $value['p'],
				'speed' => $value['s'],
				'24h_price' => $data_24h[$key]['p'],
				'24h_speed' => $data_24h[$key]['s'],
			);
		endforeach;
		ksort($stats_global);
		return $stats_global;
	}

	
	function get_algos($online = false) {
		$data = $this->get('mining/algorithms', $online);
		$data = $data['miningAlgorithms'];
		foreach ($data as $key => $value):
			$algos[$value['order']] = $value;
		endforeach;
		ksort($algos);
		return $algos;
	}
	
	
	function get_mining($btc_address, $online) {
		$api_path = 'mining/external/'.$btc_address.'/rigs';
		//$api_path = 'mining/external/'.$btc_address.'/rig/L154';
		$data = $this->get($api_path, $online);
		return $data;
	}
	
	
	function get_mining_rig($btc_address, $rig_name, $online) {
		$api_path = 'mining/external/'.$btc_address.'/rig/'.$rig_name;
		$data = $this->get($api_path, $online);
		return $data;
	}	

	
	function get_profitability_all($online = false) {
		$api_path = 'public/profcalc/devices';
		$data = $this->get($api_path, $online);
		$data = $data['devicesShort'];
		return $data;
	}
	
	
	function get_profitability_device($device, $online = false) {
		$api_path = 'public/profcalc/device?device='.$device;
		$data = $this->get($api_path, $online);
		return $data;
	}
}


function check_array($array) {
	// array check tool, great for debugging
	echo '<pre>';
	if (is_array($array)):
		print_r($array);
	else:
		var_dump($array);
	endif;
	echo '</pre>';
}


function convert_v2k($data, $new_key) {
	// generate array key from a specific value
	// return same value
	foreach ($data as $key => $value):
		$new_data[$value[$new_key]] = $value;	
	endforeach;
	return $new_data;
}


function array2table($array, $field, $format, $align) {
	// create table from array
	// field name for sorting
	// number format 0 or 8
	// align left, right, center
    $html = '<table>';
    $html .= '<tr>';
	$html .= '<th>key</th>';
    foreach($field as $key => $value):
		$html .= '<th>'.$value.'</th>';
    endforeach;
    $html .= '</tr>';
    foreach($array as $key => $value):
        $html .= '<tr>';
		$html .= '<td>'.$key.'</td>';
        foreach($field as $akey => $avalue):
			$text = $value[$avalue];
			if ($format[$akey] == 'num_8'):
				$text = number_format($value[$avalue], 8);
			elseif ($format[$akey] == 'num_6'):
				$text = number_format($value[$avalue], 6);
			elseif ($format[$akey] == 'num_0'):
				$text = number_format($value[$avalue], 0);
			endif;
			$td = '<td>';
			if ($align[$akey] == 'c'):
				$td = '<td style="text-align:center">';
			elseif ($align[$akey] == 'r'):
				$td = '<td style="text-align:right">';
			endif;
			$html .= $td.$text.'</td>';
        endforeach;
        $html .= '</tr>';
    endforeach;
    $html .= '</table>';
    return $html;
}
?>
