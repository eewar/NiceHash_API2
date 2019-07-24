<?php
include('nh2.php');

$btc_address = 'sdfsfsdfsdfdsfsdfdsfdsfdsffs';

$nh = new NH();
$mining = $nh->get_mining($btc_address, true); // change to false for read from cache file
check_array($mining);
?>
