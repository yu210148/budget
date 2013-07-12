#!/usr/bin/php
<?php
require_once 'standard_functions.php';
function set_number_of_weeks($db, $numberOfWeeks){
  $sql = "UPDATE Config SET Value = $numberOfWeeks WHERE Parameter = 'NumberOfWeeks'";
  send_query($db, $sql);
} // end function definition for set_number_of_weeks()

$db = connect_to_mysql();
$numberOfWeeks = $_POST["numberOfWeeks"];
set_number_of_weeks($db, $numberOfWeeks);
unset($db);
?>