<?php 

include('../classes/clean.php');
include('../classes/api_auth.php');
include('../php_includes/error_handle.php');
include('../classes/security.php');
include('../classes/user_mgt.php');
include('../classes/wards.php');




$start = new api_auth;
$create = $start->create_index();
print_r($create);
?>