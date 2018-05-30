<?php
include("../php_includes/call_api.php");

if(isset($_GET["q"])){
$q = $_GET["q"];
$s = $_GET["s"];
$fcall = new call_api;
$lga = $fcall->get_wards($s, $q);

echo "Wards: <select class=\"form-control\" name=\"wards\" form=\"join-party\" id=\"wards\" required>";
echo "<option disabled selected>Select Ward</option>";
foreach($lga as $x){
    $ward = $x->ward;
    echo "<option value=\"$ward\">$ward</option>";
}
echo "</select>";
} else {

    echo "Error select state again";
}


?>