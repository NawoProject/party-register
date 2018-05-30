<?php
    include("../php_includes/call_api.php");

//required arguments
$fcall = new call_api;
$user = $fcall->get_latest_blocks();


//custom page info
$page_title = "Public Party Register Demo - Latest blocks";
include("../php_includes/header.php");
?>

<div class="container bigcont bpad">
    <div class="row">
        <h3>
            View latest blocks.
        </h3>
    </div>
    
    <div class="row">
        <h3>
            Latest blocks
        </h3>
        <br /><br />
        <?php 
        
        if (isset($user)){
            $user = (array)$user;
            
            foreach ($user as $x){
                $x = (array)$x;
                if(!isset($x["user_hash"])){
                    echo "No user found <br />";
                    break;
                }
                $user_hash = $x["user_hash"];
                $entry_date = $x["entry_date"];
                date_default_timezone_set('Africa/Lagos');
                $entry_date = date('d M Y H:i:s', $entry_date);
                $ward = $x["ward"];
                $lga = $x["lga"];
                $state = $x["state"];
                $payment = $x["payment_status"];
                $block_hash = $x["block_hash"];

                echo "
                    <p>
                    <span class=\"break-word\">Unique user hash: $user_hash</span><br />
                    Date: $entry_date<br />
                    Ward: $ward<br />
                    LGA: $lga<br />
                    State: $state<br />
                    Status: $payment<br />
                    <span class=\"break-word\">Block hash: $block_hash</span><br /><br />
                    </p> 
                ";


            } //end foreach 
        } //end if 
        
        ?>
    </div>
</div><!--end container--> 



<?php
include("../php_includes/footer.php");
?>