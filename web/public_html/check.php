<?php

if(isset($_POST["first_name"])){
    
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $surname = $_POST["surname"];
    $birth_month = $_POST["birth_month"];
    $birth_year = $_POST["birth_year"];
    $sauce = $_POST["sauce"];


    include("../php_includes/call_api.php");


    $fcall = new call_api;
    $data = array(
    "first_name" => $first_name,
    "middle_name" => $middle_name,
    "surname" => $surname,
    "birth_month" => $birth_month,
    "birth_year" => $birth_year,
    "sauce" => $sauce
);
$data = json_encode($data);
$user = $fcall->find_user_info($data);
}

if(isset($_POST["user_hash"])){
    
    $user_hash = $_POST["user_hash"];
    
    include("../php_includes/call_api.php");


    $fcall = new call_api;
    $data = array(
    "user_hash" => $user_hash
);
$data = json_encode($data);
$user = $fcall->find_from_hash($data);
}

//custom page info
$page_title = "Public Party Register Demo - Check your status in register";
include("../php_includes/header.php");
?>

<div class="container bigcont bpad">
    <div class="row">
        <h3>
            Check your status in register.
        </h3>
    </div>
    <div class="row">
        <br /><br />
        <form action="./check.php" method="post" class="form-inline" name="join-party" id="join-party">
            <div class="form-group">
            Names:  <input form="join-party" class="form-control" type="text" id="first_name" name="first_name" placeholder="First Name" required></input>
                    <input form="join-party" class="form-control" type="text" id="middle_name" name="middle_name" placeholder="Middle Name"></input>
                    <input form="join-party" class="form-control" type="text" id="surname" name="surname" placeholder="Surname" required></input><br /><br />
        Date of Birth: <select form="join-party" class="form-control" type="text" id="birth_month" name="birth_month" required>
                        <option disabled selected>Month</option>
                        <option value="January">January</option>
                        <option value="Febrary">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
            </select>
            <select form="join-party" class="form-control" type="text" id="birth_year" name="birth_year" required>
                <option disabled selected>Year</option>
                <?php
                date_default_timezone_set('Africa/Lagos');
                $year = date("Y");
                $year = $year - 15;
                $sdate = $year - 100;
                while ($sdate != $year) {
                    echo "<option value=\"$sdate\">$sdate</option>";
                    $sdate = $sdate+1;
                } 
                ?>
            </select> <br /><br />
            Secret: <input form="join-party" class="form-control" type="password" id="sauce" name="sauce" placeholder="Secret" required></input> 
            </div>
            <br /><br />
            <button type="submit" id="submitbutton" class="btn btn-primary" form="join-party">Check</button>
        </form>
    </div>

    <br />
    <br />
    <div class="row">
        <h3>
            Check with unique user hash.
        </h3>
    </div>
    <div class="row">
        <br /><br />
        <form action="./check.php" method="post" class="form-inline" name="check-hash" id="check-hash">
            <div class="form-group">
            User hash:  <input form="check-hash" class="form-control" type="text" id="user_hash" name="user_hash" placeholder="User hash" required></input>
            </div>
            <br /><br />
            <button type="submit" id="submitbutton2" class="btn btn-primary" form="check-hash">Check</button>
        </form>
    </div>


    <div class="row">
        <h3>
            Your Details
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