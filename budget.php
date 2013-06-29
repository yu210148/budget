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

function print_header(){
print <<<HERE
<div class='fixed_expenses'>
  <table>
    <tr>
      <td><input type='checkbox' name='phone'></td>
      <td>Phone</td>
      <td>25.18</td>
    </tr><tr>
      <td><input type='checkbox' name='net'></td>
      <td>Net</td>
      <td>41.80</td>
    </tr><tr>
      <td><input type='checkbox' name='rent'></td>
      <td>Rent</td>
      <td>1425.10</td>
    </tr><tr>
      <td><input type='checkbox' name='cell'></td>
      <td>Cell</td>
      <td>54.24</td>
    </tr><tr>
      <td><input type='checkbox' name='mpass'></td>
      <td>MPass</td>
      <td>117.75</td>
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
print_header();
print_grl();
print_run();
?>
</body>

