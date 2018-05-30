<?php
/*class for security
include functions to
- generate random user hashes
- encrypt member details in database with public key
NB: private keys stored offsite and in secure location
- includes service to fetch email address and phone numbers on request by valid user
*/


class na_security{
    //attributes
  private $pb_key;
  

  //include database functions in connects
   function __construct(){
     require('../config/na_config.php'); //require configuration file
     $this->pb_key = base64_decode($pb_key);
   }


    // generate user personal details hash
    function gen_user_hash($fname, $mname, $lname, $bmonth, $byear, $stoken){
        $combine = "$fname.$mname.$lname.$bmonth.$byear.$stoken";
        $hash = hash("sha512", $combine);
        return $hash;
    } //end function

    function gen_simple_hash($fname, $mname, $lname, $bmonth, $byear){
        $combine = "$fname.$mname.$lname.$bmonth.$byear";
        $hash = hash("sha512", $combine);
        return $hash;
    } //end function


      //generate new hash
    function gen_new_block_hash($userhash, $entry_date, $last_hash){
        $combine = "$userhash.$entry_date.$last_hash";
        $newhash = hash("sha512", $combine);
        return $newhash;
    } //end function

    function enc_value($input){
        openssl_public_encrypt($input, $enc, $this->pb_key); 
        $simple = base64_encode($enc);
        return $simple;
    } //end function 

    function dec_value($input, $pv_key){
        $pkey = base64_decode($pv_key);
        openssl_private_decrypt($input, $dec, $pkey); 
        $simple = base64_encode($dec);
        return $simple;
    }
}
?>