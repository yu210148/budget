<?php
require_once 'standard_functions.php';

function update_db($db){
  $sql = "UPDATE FixedExpenses SET FixedExpenses.fChecked = 0 WHERE FixedExpenses.FixedExpensesID = 1";
  send_query($db, $sql);
}


$name = $_POST["name"];
$location = $_POST["location"];
$db = connect_mysql_pdo();

update_db($db);

unset($db);
?>