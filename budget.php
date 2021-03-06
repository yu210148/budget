<html>
<head>
<title>Budget</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="budget.js"></script>
<link rel="stylesheet" href="smoothness/jquery-ui-1.10.3.custom.min.css">
<link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
<link rel=StyleSheet href="budget.css" type="text/css">
<head>
<body>
<div id='document'>
<?php
/*
    budget displays a personal budget check list and keeps track
    of how much has been spent in a month (or set number of weeks)
    
    Copyright (C) 2014  Kevin Lucas

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/



/**
* Documentation, License etc.
* Licence GPL v2 or later.
* yu210148@gmail.com klucas@teksavvy.com klucas@utpress.utoronto.ca
* @package budget
*/
 require_once 'standard_functions.php';
 date_default_timezone_set('America/Toronto');

function refresh_fixed_expenses_table($db){
 // this function is not called as this is a constant table and 
 // does not need to be refreshed.  I wrote this very early in 
 // the morning before I realized what I was doing :) 
 // --kev. 2013-07-01
  $sql = "DROP TABLE IF EXISTS FixedExpenses";
  send_query($db, $sql);
  
  $sql = "CREATE TABLE FixedExpenses (
    FixedExpensesID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(15),
    Amount DECIMAL(7,2),
    fChecked TINYINT
    )";
  send_query($db, $sql);
  
  $sql = "SELECT Config.PhoneFixedExpense, Config.NetFixedExpense, Config.RentFixedExpense, Config.CellFixedExpense, Config.MPassFixedExpense FROM Config";
  $q = send_query($db, $sql);
  
  while ($row = $q->fetchAll(PDO::FETCH_ASSOC)){
    $sql = "INSERT INTO FixedExpenses VALUES ( NULL, '$row[PhoneFixedExpense]', '$row[NetFixedExpense]', '$row[RentFixedExpense]', '$row[CellFixedExpense]', '$row[MPassFixedExpense]' )";
    send_query($db, $sql);
  } // end while  
  return 0;
 } // end function definition for refresh_fixed_expenses_table($db)
 
function print_header($db){
print <<<HERE
<div id="fixed_expenses">
  <table id="fixed_expenses_table" class="ui-widget-content">
HERE;

$sql = "SELECT
	  FixedExpenses.Name,
	  FixedExpenses.Amount,
	  FixedExpenses.fChecked
	FROM
	  FixedExpenses
	";
$q = send_query($db, $sql);
while ($row = $q->fetch(PDO::FETCH_ASSOC)){
  print "<tr>";
print <<<HERE
<form id=fixed>
<td><input type='checkbox' name=$row[Name]
HERE;
  if ($row['fChecked'] == 1){
    print " checked>";
  } else {
    print ">";
  } // end else
  print "</td>";
  print "<td>$row[Name]</td>";
  print "<td>$row[Amount]</td>";
  print "</tr>";
} // end while

print <<<HERE
   </table>
   </form>
</div>
HERE;
} // end function definition for print_header()

function get_current_number_of_weeks($db){
  $sql = "SELECT Config.HowManyWeeksGRL FROM Config WHERE ConfigID = 1";
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $numberOfWeeks = $row['HowManyWeeksGRL'];
  } // end while
  return $numberOfWeeks;
} // end function definition for get_current_number_of_weeks()

function get_total_grl($db){
  // a function to read the total grl and return it
  $sql = "SELECT Config.TotalGRLPerWeek FROM Config WHERE Config.ConfigID = 1";
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $amount = $row['TotalGRLPerWeek'];
  } // end while
  return $amount;
} // end function definition get_total_grl()

function get_total_run($db){
  // a function to read the total run and return it
  $sql = "SELECT Config.TotalRUNPerWeek FROM Config WHERE Config.ConfigID = 1";
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $amount = $row['TotalRUNPerWeek'];
  } // end while
  return $amount;
} // end function definition

function create_grl_tables($db){
  // a function to create the tables for the set number of weeks
  // not sure if this goes here  or not but it's got to go somewhere
  $numberOfWeeks = get_current_number_of_weeks($db);
  $totalGRL = get_total_grl($db);
  $i = 1;
  while ($i <= $numberOfWeeks){
    $sql = "CREATE TABLE grl_week$i (grl_week$i" . "ID INT NOT NULL AUTO_INCREMENT, Amount INT, fChecked INT, PRIMARY KEY ( grl_week$i" . "ID )) ";
    send_query($db, $sql);
    // insert values in multiples of 20
    $p = 20;
    while ($p <= $totalGRL){ //TODO: the magic number 100 here is the total for grl and should be set in the config table
      $sql = "INSERT INTO grl_week$i VALUES (NULL, $p, 0)";
      send_query($db, $sql);
      $p = $p + 20;
    } // end while
    $i++;
  } // end while
  return 0;
} // end function definition

function create_run_tables($db){
  // a function to create tables for the set number of weeks
  // like the grl table create function, I'm not sure if this
  // goes here but for now....
  $numberOfWeeks = get_current_number_of_weeks($db);
  $i = 1;
  while ($i <= $numberOfWeeks){
    $sql = "CREATE TABLE run_week$i (run_week$i" . "ID INT NOT NULL AUTO_INCREMENT, Amount INT, fChecked INT, PRIMARY KEY ( run_week$i" . "ID )) ";
    send_query($db, $sql);
    // insert values in multiples of 20
    $p = 20;
    while ($p <= 120){ // TODO: the magic number 120 here is the total for run and should be set in the config table
      $sql = "INSERT INTO run_week$i VALUES (NULL, $p, 0)";
      send_query($db, $sql);
      $p = $p + 20;
    } // end while
    $i++;
  } // end while
  return 0;
} // end function definition

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

function print_grl($db){
$numberOfWeeks = get_current_number_of_weeks($db);
$total = get_total_grl($db);
print <<<HERE
<div id='grl'>
  <table id="grl_table" class="ui-widget-content">
    <tr>
      <th colspan=5><center>$total GRL</center></th>
    </tr>
HERE;

$i = 1;
$amount = 20;
while ($i <= $numberOfWeeks){
  print "<tr>";
  while ($amount <= 100){ //TODO: get the 100 magic number from the config db here
    $isChecked = is_grl_checked($db, $i, $amount);
    if ($isChecked == 0){
      print "<td><input id='$i' type='checkbox'>$amount</td>";
    } else {
      print "<td><input id='$i' type='checkbox' CHECKED>$amount</td>";
    } // end else
    $amount = $amount + 20;
  } // END while
  print "</tr>";
  $i++;
  $amount = 20;
} // end while
print "</table></div>";
return 0;
} // end function definition for print_grl()

function is_run_checked($db, $weekNumber, $amount){
  // function that takes the week number and amount
  // and returns 0 if it's not checked 1 if it is
  $sql = "SELECT fChecked FROM run_week$weekNumber WHERE Amount = $amount";
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $isChecked = $row['fChecked'];
  } // end while
  if (0 == $isChecked){
    return 0;
  } else {
    return 1;
  } // end else
} // end function definition

function print_run($db){
$numberOfWeeks = get_current_number_of_weeks($db);
$total = get_total_run($db);
print <<<HERE
<div id='run'>
  <table id="run_table" class="ui-widget-content">
    <tr>
      <th colspan=6><center>$total Run</center></th>
    </tr>
HERE;
$i = 1;
$amount = 20;
while ($i <= $numberOfWeeks){
  print "<tr>";
  while ($amount <= 120){ //TODO: get the 120 magic number from the config db here
    $isChecked = is_run_checked($db, $i, $amount);
    if ($isChecked == 0){
      print "<td><input id='$i' type='checkbox'>$amount</td>";
    } else {
      print "<td><input id='$i' type='checkbox' CHECKED>$amount</td>";
    } // end else
    $amount = $amount + 20;
    } // end while
  print "</tr>";
  $i++;
  $amount = 20;
} // end while
print "</table></div>";
return 0;
} // end function definition for print_run()

function print_controls($db){
$numberOfWeeks = get_current_number_of_weeks($db);
print <<<HERE
<div id='controls' class="ui-widget-content">
<b><center>Controls</center></b>
<input type='text' id='num_of_weeks' name='num_of_weeks' value='$numberOfWeeks' onkeyup="update_number_of_weeks('num_of_weeks');">
<a href="#" id='grl_reset' onclick="refresh_grl_tables();">Reset GRL</a> 
</div>
HERE;
} // end function definition for print controls()

// HERE'S MAIN
$db = connect_to_mysql();

print_header($db);

// testing this doesn't go here really
//create_grl_tables($db);
//create_run_tables($db);

print_grl($db);
print_run($db);
//print_controls($db);


unset($db);
?>
</div>
</body>
</html>
