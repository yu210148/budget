<?php
require_once 'standard_functions.php';

function update_db($db, $name){
  $sql = "UPDATE FixedExpenses SET FixedExpenses.Name = 'Phone' WHERE FixedExpenses.FixedExpensesID = 1";
  send_query($db, $sql);
  
}


$name = $_POST["name"];
$location = $_POST["location"];
$db = connect_to_mysql();

update_db($db, $name);

unset($db);
?>