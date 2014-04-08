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