<?php
include("../php_includes/call_api.php");

if(isset($_GET["q"])){
$q = $_GET["q"];
$fcall = new call_api;
$lga = $fcall->get_lgas($q);

echo "LGA: <select class=\"form-control\" name=\"lga\" form=\"join-party\" id=\"lga\" required onChange=\"get_wards(this.value);\">";
echo "<option disabled selected>Select LGA</option>";
foreach($lga as $x){
    echo "<option value=\"$x\">$x</option>";
}
echo "</select>";
} else {

    echo "Error select state again";
}


?>