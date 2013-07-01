<html>
<head>
<title>Budget</title>
<head>
<body>
<?php
/**
* Documentation, License etc.
*
* @package budget
*/
 require_once 'standard_functions.php';

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
<div class='fixed_expenses'>
  <table>
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

//debug
//var_dump($row);

  print "<tr>";
print <<<HERE
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
</div>
HERE;
} // end function definition for print_header()

function print_grl(){
print <<<HERE
<div class='grl'>
  <table>
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
} // end function definition for print_grl()

function print_run(){
print <<<HERE
<div class='run'>
  <table>
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
} // end function definition for print_run()



// HERE'S MAIN
$db = connect_to_mysql();

print_header($db);
print_grl();
print_run();



unset($db);
?>
</body>

