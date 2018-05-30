<?php
/* 
* Check you party status
* Returns User hash, join/update date, Party Status and expiry dates with block hashes. 
* Requires First name, middle name, surname, birth month, birth year, and secret sauce.
* 
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

 $exp = array("first_name", "surname", "birth_month", "birth_year", "sauce");
 foreach ($exp as $value) {
   if (empty($data->$value)){
     $error_counter = $error_counter +1;
   }
 }
 if($error_counter>0){
   echo error_response(400, 'Incorrect parameters');
   exit();
 }

//get arguments
$fname = $data->first_name;
if(isset($data->middle_name)){
$mname = $data->middle_name;
} else {
    $mname = "";
}
$sname = $data->surname;
$bmonth = $data->birth_month;
$byear = $data->birth_year;
$sauce = $data->sauce;


$clean = new na_clean;
$fname = $clean->clean_str($fname);
$mname = $clean->clean_str($mname);
$sname = $clean->clean_str($sname);
$sauce = $clean->clean_str($sauce);


//Query database
$join = new na_users;
$result = $join->get_user_details($fname, $mname, $sname, $bmonth, $byear, $sauce);

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
