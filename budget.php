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
<?php
/**
* Documentation, License etc.
*
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

function print_grl(){
print <<<HERE
<div id='grl'>
  <table id="grl_table" class="ui-widget-content">
    <tr>
      <th colspan=5><center>500 GRL</center></th>
    </tr>
HERE;
$i = 1;
$amount = 20;
while ($i <= 4){
  print "<tr>";
  while ($amount <= 100){
    print "<td><input type='checkbox'>$amount</td>";
    $amount = $amount + 20;
  } // END while
  print "</tr>";
  $i++;
  $amount = 20;
} // end while
print "</table></div>";
return 0;
} // end function definition for print_grl()

function print_run(){
print <<<HERE
<div id='run'>
  <table id="run_table" class="ui-widget-content">
    <tr>
      <th colspan=6><center>600 Run</center></th>
    </tr>
HERE;
$i = 1;
$amount = 20;
while ($i <= 6){
  print "<tr>";
  while ($amount <= 120){
    print "<td><input type='checkbox'>$amount</td>";
    $amount = $amount + 20;
    } // end while
  print "</tr>";
  $i++;
  $amount = 20;
} // end while
print "</table></div>";
return 0;
} // end function definition for print_run()

function print_controls(){
print <<<HERE
<div id='controls'>
<br>

<a href="#" id='grl_reset' onclick="refresh_grl_tables();">Reset GRL</a> 

<input type='text' id='num_of_weeks' name='num_of_weeks' onchange="update_number_of_weeks('num_of_weeks');">

<br>
</div>
HERE;
} // end function definition for print controls()

// HERE'S MAIN
$db = connect_to_mysql();

print_header($db);
print_grl();
print_run();
print_controls();


unset($db);
?>
</body>

