<?php
//cron task that runs every so minutes to process blocks ordered by timestamp.

// include required files
include('../classes/clean.php');
include('../classes/api_auth.php');
include('../php_includes/error_handle.php');
include('../classes/security.php');
include('../classes/user_mgt.php');
include('../classes/wards.php');


//extend processing time
ini_set('max_execution_time', 1800); //1800 seconds = 30 minutes

//Get next 100 unprocessed blocks
$public_db = new na_users;
$blocks = $public_db->get_unprocessed_blocks();

//get last processed hash
$x = 0;
$y = count($blocks);

while ($x < $y){
    $bl_array = $blocks["$x"];

    $obj_id = $bl_array->{'_id'};
    $obj_id = (array)$obj_id;
    $obj_id = $obj_id['oid'];
    
    $user_hash = $bl_array->user_hash;
    $entry_date = $bl_array->entry_date;

    
    //get last hash
    $sec = new na_security;
    $last_hash = $public_db->get_last_block_hash();
    $lhash = $last_hash->block_hash;
    $ldate = $last_hash->entry_date;
    echo "last hash: $lhash<br />";
    
    //gen new hash
    $new_hash = $sec->gen_new_block_hash($user_hash, $entry_date, $lhash);
    

    //update user db
    $update = $public_db->update_next_user($obj_id, $new_hash);

    //wait 1 seconds 
    sleep(1);

    
    $wait = 0;
    while($wait != 1){
        $test_hash = $public_db->get_last_block_hash()->block_hash;

        if($test_hash == $last_hash){
            // wait one more second. Keep waiting until finish
            sleep(1);
        } else {
        $wait = 1;
        $x = $x+1;
        }
    } // end internal while loop
 echo " New hash: $new_hash <br /><br />";

} // end while loop

?>