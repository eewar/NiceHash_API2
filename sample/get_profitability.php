<?php
include('nh2.php');

$nh = new NH();
$data = $nh->get_profitability_all(true); // change to false for read from cache file

$field = array('name', 'niceName', 'category', 'paying', 'id');
$format = array('', '', '', 'num_6', '');
$align = array('', '', '', 'r', '');

echo array2table($data, $field, $format, $align);
?>
