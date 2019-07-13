<?php
$devices_id = array(
	'e638010c-73a4-4673-ad23-30c838797490',
	'5c76b698-a2d9-445c-aad4-38964dd35421',
	'869da26b-6e22-4819-8996-a19acfb9ec0d',
);


foreach ($devices_id as $key => $value):
	$url = 'https://api2.nicehash.com/main/api/v2/public/profcalc/device?device='.$value.'';
	$json = file_get_contents($url);
	$array = json_decode($json, true);
	$array['speeds'] = json_decode($array['speeds'], true);
	$speeds[$array['niceName']] = $array['speeds'];
endforeach;

check_array($speeds);

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