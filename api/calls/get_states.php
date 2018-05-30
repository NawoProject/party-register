<?php
/*Get uniqe states from wards database
* @author Nonso Obikili
*/

$method = "POST";
$authentication = TRUE;



  $temp = new na_wards;
  $get_states = $temp->get_states();
  if($get_states[0]==TRUE){
  header('Status: 200 OK');
  $ret = json_encode(array(
      'status' => 200, // success or not?
      'message' => $get_states[1],
      ));
  print_r($ret);
} else {
    echo error_response(400, $get_states[1]);
    exit();
}

 ?>
