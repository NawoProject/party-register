<?php
/* 
* Get the latest blocks from register.
*/

$method = "POST";




//Query database
$blocks = new na_users;
$result = $blocks->get_latest_blocks();

if($result!=FALSE){
header('Status: 200 OK');
$return = json_encode(array(
    'status' => 200, // success or not?
    'message' => 'OK',
    'details' => $result
    ));
print_r($return);
} else {
echo error_response(400, "No results");
}

?>
