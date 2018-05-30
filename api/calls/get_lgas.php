<?php
/*Get uniqe states from wards database
* @author Nonso Obikili
*/

$method = "POST";
$authentication = TRUE;


// Check if expected json sent
  if(!isset($_POST["data"])){
    echo error_response(400, 'Bad request');
    exit();
  } else {
  $data = json_decode($_POST['data']);
 }


 // check if required arguments sent, extract and clean, except event_orgs array
 //error counter
 $error_counter = 0;
 $clean = new na_clean;
 $exp = array("state");
 foreach ($exp as $value) {
   if (empty($data->$value)){
     $error_counter = $error_counter +1;
   }
 }
 if($error_counter>0){
   echo error_response(400, 'Required arguments incomplete 1');
   exit();
 }

//Get and clean all vars
$state = $clean->clean_str2($data->state);



  $temp = new na_wards;
  $get_lgas = $temp->get_lgas($state);
  if($get_lgas[0]==TRUE){
  header('Status: 200 OK');
  $ret = json_encode(array(
      'status' => 200, // success or not?
      'message' => $get_lgas[1],
      ));
  print_r($ret);
} else {
    echo error_response(400, $get_lgas[1]);
    exit();
}

 ?>
