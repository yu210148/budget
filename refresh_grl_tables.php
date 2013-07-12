#!/usr/bin/php
<?php
require_once 'standard_functions.php';

function get_number_of_weeks($db){
  $sql = "SELECT Config.Value FROM Config WHERE Config.Parameter = 'NumberOfWeeks'";
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $NumberOfWeeks = $row['Value'];
  } // end while
  return $NumberOfWeeks;
} // end function definition for get_number_of_weeks()

function drop_tables($db, $numberOfWeeks){
  $i = 1;
  while ($i <= $numberOfWeeks + 6){
    $sql = "DROP TABLE IF EXISTS grl_week$i";
    send_query($db, $sql);
    $i++;
  } // end while
  return 0;
} // end function definition for drop_tables()

function create_tables($db, $numberOfWeeks){
  $i = 1;
  while ($i <= $numberOfWeeks){
    $fields = "GrlWeek" . $i . "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, Amount INT, fChecked TINYINT";
    $sql = "CREATE TABLE grl_week$i ( $fields )";
    send_query($db, $sql);
    $i++;
  } // end while
  return 0;
} // end function definition for create_tables()

function insert_data($db, $numberOfWeeks){
  $i = 1;
  $amount = 20;
  while ($i <= $numberOfWeeks){
    while ($amount <= 100){
      $sql = "INSERT INTO grl_week$i VALUES ('', '$amount', 0)";
      send_query($db, $sql);
      $amount = $amount + 20;
    } // end while
  $amount = 20; 
  $i++;
  } // end while
  return 0;
} // end function definition for insert_data()

$db = connect_to_mysql();

// test data
//$numberOfWeeks = 5;

$numberOfWeeks = get_number_of_weeks($db);
drop_tables($db, $numberOfWeeks);
create_tables($db, $numberOfWeeks);
insert_data($db, $numberOfWeeks);

unset($db);
?>