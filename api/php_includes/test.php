<?php
require("../config/na_config.php");

echo "$pb_key";
$test = base64_decode($pb_key);
echo "<br /><br /> $test";

?>