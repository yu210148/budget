<?php
require_once 'standard_functions.php';
function is_grl_checked($db, $weekNumber, $amount){
  // function that takes the week number and amount
  // and returns 0 if it's not checked 1 if it is in
  // the database
  $sql = "SELECT fChecked FROM grl_week$weekNumber WHERE Amount = $amount";
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $isChecked = $row['fChecked'];
  } // end while
  if (0 == $isChecked){
    return 0;
  } else {
    return 1;
  } // end else
} // end function definition is_grl_checked()

function update_grl_table($db, $weekNumber, $amount, $isChecked){
  // if the item is already checked we want to un-check it here
  // otherwise we check it off by making it's value 1
  if (0 == $isChecked){
    $isChecked = 1;
  } else {
    $isChecked = 0;
  } // end else
  $sql = "UPDATE grl_week$weekNumber SET fChecked = $isChecked WHERE Amount = $amount";
  send_query($db, $sql);
  return 0;
} // end function definition for update_grl_table()

$db = connect_to_mysql();

$weekNumber = $_POST["weekNumber"];
$amount= $_POST["amount"];
// test data
$weekNumber = 1;
$amount = 20;

// find out if the element is already checked or not
$isChecked = is_grl_checked($db, $weekNumber, $amount);
update_grl_table($db, $weekNumber, $amount, $isChecked);


unset($db);
?>