<?php
/* 
Generate new api key for client
Requires email address.
*/

$method = "POST";

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

 $exp = array("email");
 foreach ($exp as $value) {
   if (empty($jdets->$value)){
     $error_counter = $error_counter +1;
   }
 }
 if($error_counter>0){
   echo error_response(400, 'Incorrect parameters');
   exit();
 }

//get arguments
$email = $data->email;


$clean = new na_clean;
if($clean->val_email($email)==FALSE){
    echo error_response(400, 'Invalid email address');
   exit();
}

//Generate new api key
$gen = new api_auth;
$result = $gen->get_new_api($email);

if($result!=FALSE){
header('Status: 200 OK');
$return = json_encode(array(
    'status' => 200, // success or not?
    'message' => 'API Key generated. Please check your email for key'
    ));
print_r($return);
} else {
echo error_response(400, "Error generating API key");
}

?>
