<?php
/*
Class to recieve user details and enter into database
and update database with payment and expiry information
Functions include
- add fresh user
- update fresh user with payment confirmed info, membership expiry date, link to payment, and any other info
- reinsert user data upon renewal
*/

class na_users{

    //attributes
  private $db_server;
  private $db_name;
  private $db_username;
  private $db_pass;
  private $comp_path;
  private $serverName = "Local testing server";


  //include database functions in connects
   function __construct(){
     require('../config/na_config.php'); //require configuration file
     require($comp_path); //require composer mongodb lib
     $this->db_name = $db_name;
     $this->db_username = $db_username;
     $this->db_pass = $db_pass;
     $this->db_server = $db_server;
   }

   //Function adds new user. cleans name first though
   function add_new_member($fname, $mname, $sname, $bmonth, $byear, $sauce, $ward, $lga, $state, $email, $number){
    
        //clean vars
        $clean = new na_clean;
        $fname = $clean->clean_str($fname);
        $mname = $clean->clean_str($mname);
        $sname = $clean->clean_str($sname);
        $sauce = $clean->clean_str($sauce);
        $bmonth = $clean->val_month($bmonth);
        $byear = $clean->val_year($byear);
        $ward = $clean->clean_str($ward);
        $lga = $clean->clean_str($lga);
        $state = $clean->clean_str($state);
        $number = $clean->clean_str($number);

        
        //encrypt data
        $enc = new na_security;
        $efname = $enc->enc_value($fname);
        $emname = $enc->enc_value($mname);
        $esname = $enc->enc_value($sname);
        $ebmonth = $enc->enc_value($bmonth);
        $ebyear = $enc->enc_value($byear);
        $eemail = $enc->enc_value($email);
        $enumber = $enc->enc_value($number);

        //get user hash id
        $userid = $enc->gen_user_hash($fname, $mname, $sname, $bmonth, $byear, $sauce);
        $simple = $enc->gen_simple_hash($fname, $mname, $sname, $bmonth, $byear);
        $hemail = hash("sha512", "$sname$email");
        $hnumber = hash("sha512", "$sname$number");

        //get timestamp
        $cur_date = $clean->new_time();

        //insert user in database
        $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
         $x = $this->db_name;
         $collection = $client->$x->na_register; //Select collection

         $document = array(
            "first_name" => "$efname",
            "middle_name" => "$emname",
            "surname" => "$esname",
            "birth_month" => "$ebmonth",
            "birth_year" => "$ebyear",
            "entry_date" => $cur_date,
            "simple_id" => $simple
          );
     
           try  {
              $insertOneResult = $collection->insertOne($document);
              if ($insertOneResult->getInsertedCount() == 1) {
                $ret = $insertOneResult->getInsertedId();
                }
            } catch(\Exception $e){
                 $f = "Failed to add user for some reason. Try again";
                $ret = FALSE;
                return $ret;
                exit();
           }

           //insert into public database

          $collection2 = $client->$x->na_publicdb; //Select collection

         $document2 = array(
          "user_hash" => "$userid",
          "entry_date" => $cur_date,
          "ward" => "$ward",
          "lga" => "$lga",
          "state" => "$state",
          "payment_status" => "pending",
          "block_hash" => "NULL"          
          );
     
           try  {
              $insertOneResult2 = $collection2->insertOne($document2);
              if ($insertOneResult2->getInsertedCount() == 1) {
                $ret = $insertOneResult2->getInsertedId();
                }
            } catch(\Exception $e){
                 $f = "Failed to add user for some reason. Try again";
                $ret = FALSE;
                return $ret;
                exit();
           }
           
           //insert encrypted contact information
           $collection3 = $client->$x->na_contacts; //Select collection

           $document3 = array(
            "user_hash" => "$userid",
            "entry_date" => $cur_date,
            "enc_email" => "$eemail",
            "hash_email" => "$hemail",
            "enc_number" => "$enumber",
            "hash_number" => "$hnumber"     
            );
       
             try  {
                $insertOneResult3 = $collection3->insertOne($document3);
                if ($insertOneResult3->getInsertedCount() == 1) {
                  $ret3 = $insertOneResult3->getInsertedId();
                  }
              } catch(\Exception $e){
                   $f = "Failed to add user for some reason. Try again";
                  $ret = FALSE;
                  return $ret;
                  exit();
             }

           return $userid;
   } //end function


   function get_user_details($fname, $mname, $sname, $bmonth, $byear, $sauce){
      // get user details with general user info

      //generate hash
      //clean vars
      $clean = new na_clean;
      $fname = $clean->clean_str($fname);
      $mname = $clean->clean_str($mname);
      $sname = $clean->clean_str($sname);
      $sauce = $clean->clean_str($sauce);
      $bmonth = $clean->val_month($bmonth);
      $byear = $clean->val_year($byear);

     //get user hash id
     $enc = new na_security;
      $userid = $enc->gen_user_hash($fname, $mname, $sname, $bmonth, $byear, $sauce);
      
      //find in database
      //find user in database
      $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
      $x = $this->db_name;
      $collection = $client->$x->na_publicdb; //Select collection

      $query = $collection->find(
        [
          'user_hash' => $userid,
        ]
        );
      $ret = array();
       foreach($query as $res){
         $ret[] = $res;
       }
      return $ret;
   }//end function


   function get_from_hash($userhash){
    // get user details with unique user hash
    //find user in database
    $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
    $x = $this->db_name;
    $collection = $client->$x->na_publicdb; //Select collection

    $query = $collection->find(
      [
        'user_hash' => $userhash,
      ]
      );
    $ret = array();
     foreach($query as $res){
       $ret[] = $res;
     }
    return $ret;
 }//end function

 //get last valid hash, order by entry_date
 function get_last_block_hash(){
    $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
    $x = $this->db_name;
    $collection = $client->$x->na_publicdb; //Select collection

    $query = $collection->findOne(
      [
        'block_hash' => ['$not' => new MongoDB\BSON\Regex('NULL', 'i')],
      ],
      [
        'projection' => [
          'block_hash' => 1,
          'entry_date' => 1,
      ],
        'sort' => ['entry_date' => -1],
      ]
        );
  return $query;
 } //end function


 function update_next_user($obj_id, $blhash){

  $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
  $x = $this->db_name;
  $collection = $client->$x->na_publicdb; //Select collection

  $updateResult = $collection->updateOne(
    ['_id'=> new MongoDB\BSON\ObjectID($obj_id)],
    ['$set' => ['block_hash' => "$blhash"]]
);

  $res = $updateResult->getModifiedCount();
  return $res;

 } //end function


 function get_unprocessed_blocks(){
  // get user details with unique user hash
    //find user in database
    $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
    $x = $this->db_name;
    $collection = $client->$x->na_publicdb; //Select collection

    $query = $collection->find(
      [
        'block_hash' => "NULL",
      ],
      [
        'sort' => ['entry_date' => +1],
        'limit' => 100,
      ]
      );
    $ret = array();
     foreach($query as $res){
       $ret[] = $res;
     }
    return $ret;

 } //end function
 
 function get_latest_blocks(){
  // get user details with unique user hash
    //find user in database
    $client = new MongoDB\Client("mongodb://$this->db_server/$this->db_name", array( "username" => $this->db_username, "password" => $this->db_pass)); //connect to database
    $x = $this->db_name;
    $collection = $client->$x->na_publicdb; //Select collection

    $query = $collection->find(
      [
        
      ],
      [
        'sort' => ['entry_date' => -1],
        'limit' => 100,
      ]
      );
    $ret = array();
     foreach($query as $res){
       $ret[] = $res;
     }
    return $ret;

 } //end function
 

} //end class

?>