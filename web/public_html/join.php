<?php

if(!isset($_POST["first_name"])){
 echo "Required arguments incomplete";
 exit;
}

$first_name = $_POST["first_name"];
$middle_name = $_POST["middle_name"];
$surname = $_POST["surname"];
$birth_month = $_POST["birth_month"];
$birth_year = $_POST["birth_year"];
$state = $_POST["fstate"];
$lga = $_POST["lga"];
$ward = $_POST["wards"];
$sauce = $_POST["sauce"];
$sauce2 = $_POST["sauce2"];
$email = $_POST["email"];
$number = $_POST["number"];

if($sauce!=$sauce2){
    echo "Secret not valid";
    exit;
}

include("../php_includes/call_api.php");

$fcall = new call_api;
$data = array(
    "first_name" => $first_name,
    "middle_name" => $middle_name,
    "surname" => $surname,
    "birth_month" => $birth_month,
    "birth_year" => $birth_year,
    "state" => $state,
    "lga" => $lga,
    "ward" => $ward,
    "sauce" => $sauce,
    "email" => $email,
    "number" => $number
);
$data = json_encode($data);
$join = $fcall->join_party($data);


//custom page info
$page_title = "Public Party Register Demo - Join Party";
include("../php_includes/header.php");
?>

<div class="container bigcont">
    <div class="row">
        You've succesfully joined the fake political party.<br />
        <a href="./check.php">Check your status in the register</a><br />
        <a href="./register.php">Or just view the register</a><br />
    </div>
</div>



<?php
include("../php_includes/footer.php");
?>