<?php
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