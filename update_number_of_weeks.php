#!/usr/bin/php
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
function set_number_of_weeks($db, $numberOfWeeks){
  $sql = "UPDATE Config SET Value = $numberOfWeeks WHERE Parameter = 'NumberOfWeeks'";
  send_query($db, $sql);
} // end function definition for set_number_of_weeks()

$db = connect_to_mysql();
$numberOfWeeks = $_POST["numberOfWeeks"];
set_number_of_weeks($db, $numberOfWeeks);
unset($db);
?>