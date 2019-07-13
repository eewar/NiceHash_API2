<?php
$url = 'https://api2.nicehash.com/main/api/v2/mining/algorithms/';
echo '<h2>'.$url.'</h2>';
$json = file_get_contents($url);
$array = json_decode($json, true);
foreach ($array['miningAlgorithms'] as $key => $value):
	$algo_info[$value['order']] = $value;
endforeach;
//check_array($algo_info);




$url = 'https://api2.nicehash.com/main/api/v2/public/stats/global/current/';
echo '<h2>'.$url.'</h2>';
$json = file_get_contents($url);
$array = json_decode($json, true);
foreach ($array['algos'] as $key => $value):
	$rates[$value['a']] = $value;
endforeach;
//check_array($rates);


foreach($algo_info as $key => $value):
	$algo_info[$key] += $rates[$key];
endforeach;

echo array2table($algo_info);


function check_array($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}


function array2table($array) {
    $html = '<table>';
    $html .= '<tr>';
    foreach($array[0] as $key=>$value):
		$html .= '<th>' . htmlspecialchars($key) . '</th>';
    endforeach;
    $html .= '</tr>';
    foreach( $array as $key=>$value):
        $html .= '<tr>';
        foreach($value as $akey=>$avalue):
			$html .= '<td>' . htmlspecialchars($avalue) . '</td>';
        endforeach;
        $html .= '</tr>';
    endforeach;
    $html .= '</table>';
    return $html;
}

?>