<?php
include('nh2.php');

$live_data = false; // change to false for read from cache file

$nh = new NH($live_data);
$data = $nh->get_profitability_all();

$field = array('name', 'niceName', 'category', 'paying', 'id');
$format = array('', '', '', 'num_6', '');
$align = array('', '', '', 'r', '');

echo array2table($data, $field, $format, $align);
?>