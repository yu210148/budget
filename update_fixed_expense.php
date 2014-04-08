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

function update_db($db, $name, $value){
  if ($value == 'on'){
    $val = 1;
  } else {
    $val = 0;
  } // end else
  $sql = "UPDATE FixedExpenses SET FixedExpenses.fChecked = '$val' WHERE FixedExpenses.Name = '$name'";
  send_query($db, $sql);
  return 0;
}

function get_other_fields($db, $changedFieldsArray){
  $otherFields = array();
  $notInParameter = implode("', '", $changedFieldsArray);
  
  $sql = "SELECT FixedExpenses.Name FROM FixedExpenses WHERE FixedExpenses.Name NOT IN ('$notInParameter')";
  
  $q = send_query($db, $sql);
  while ($row = $q->fetch(PDO::FETCH_ASSOC)){
    $otherFields[] = $row['Name'];
  } // end while
  return $otherFields;
} // end function definition

function parse_data_string($db, $data){
  $result = array();
  // get a list of changed fields so we can find out what the other fields are
  $changedFieldsArray = array();
  // first split the string on the '&' character to separate the fields
  $fieldsAndValuesArray = explode("&", $data);

  foreach ($fieldsAndValuesArray as $key=>$val){
    $fieldsArray = explode("=", $val);
    //var_dump($fieldsArray);

    $changedFieldsArray[] = $fieldsArray[0];
    
    //update_db($db, $fieldsArray[0], $fieldsArray[1]);
  } // end foreach
  
  $otherFieldsArray = get_other_fields($db, $changedFieldsArray);
  $result[] = $changedFieldsArray;
  $result[] = $otherFieldsArray;
  return $result;
} // end function definition

function do_it($db, $resultArray){
  foreach ($resultArray[0] as $field){
    update_db($db, $field, 'on');
  } // end foreach
  foreach ($resultArray[1] as $field){
    update_db($db, $field, 'off');
  } // end foreach
  return 0;
} // end function definition

// HERE'S MAIN
$data = $_POST["data"];
$db = connect_to_mysql();

//debug
//test data
//$data = "Phone=on&Net=on&Rent=on";

// now getting data in the form of Phone=on&Net=on from javascript
// parse this data string to updat the appropriate field
$resultArray = parse_data_string($db, $data);
do_it($db, $resultArray);

//var_dump($resultArray);

unset($db);
?>