<?php
$name = $_POST["name"];
$location = $_POST["location"];

function touch_file($name, $location){
$command = "touch /tmp/$name";
exec($command);
}

touch_file($name);
?>