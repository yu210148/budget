<?php
function connect_to_mysql(){
  try {
    // change foo and bar below to username and password for the database
    $db = new PDO('mysql:host=localhost;dbname=budget;charset=utf8', 'foo', 'bar');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }
    catch (PDOException $e)
  {
    echo $e->getMessage();
  } 
  return $db;
}

function send_query($db, $sql) {
  try { 
    $q = $db->query($sql);
  }
    catch (PDOException $e)
  {
    echo $e->getMessage();
  }
return $q;
}
?>