<?php

/*
Class to clean and format variables
*/


class na_clean{

    // Removes special chars.
  function clean_str($str) {
    return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
  } //end function

  function clean_str2($str) {
    return $str;
  } //end function


  // Checks if email is valid. Returns true or false
  function val_email($email){
          //get the email to check up, clean it
          $email = filter_var($email,FILTER_SANITIZE_STRING);
          // 1 - check valid email format using RFC 822
          if (filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE) {
              return 0;
              }
          else {
          return TRUE;
        }
      } //end function

// check if valid phone number
function val_mobile($no){
    $ret = TRUE;
    return $ret;
  }


  function val_month($mnt){
    return $mnt;
  }
  
  function val_year($year){
    return $year;
  }

//Get current time stamp. Default timezone is Africa/Lagos
function new_time(){
    date_default_timezone_set('Africa/Lagos');
    $date = strtotime("now");
    return $date;
  }
}

?>