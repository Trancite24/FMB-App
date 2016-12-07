<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 4:09 PM
 *
 * This table will return the time table names
 */

include '../Connection/connection.php';

//create query to retrive the list of table names
$showTablesQuery = "SHOW TABLES";
$result = $conn->query($showTablesQuery);

//create an array for tables
$timeTableList = array();

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        $timeTableName = $row['Tables_in_findmybus'];
        if (strpos($timeTableName , 'timetable')){
            if (strpos($timeTableName , 'r0') !== false){
                array_push($timeTableList , $timeTableName);
            }
        }

    }
}