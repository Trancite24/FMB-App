<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/4/2016
 * Time: 6:05 PM
 *
 * This file will return the route table names
 */
include '../Connection/connection.php';

//create query to retrive the list of table names
$showTablesQuery = "SHOW TABLES";
$result = $conn->query($showTablesQuery);

//create an array for tables
$tableList = array();

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        $tableName = $row['Tables_in_findmybus'];
        if (!strpos($tableName , 'timetable')){
            if (strpos($tableName , 'r0') !== false){
                array_push($tableList , $tableName);
            }
        }

    }
}

