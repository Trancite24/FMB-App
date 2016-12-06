<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 7:39 AM
 *
 * This class will return a list of names of locations saved in the database
 */

include '../Connection/connection.php';
include '../TableHandler/getRouteTableNames.php';

//this query will be used to retrieve data from the Bus route Tables
$finalQuery = '';
$currentCount = 1;

foreach ($tableList as &$name) {
    $finalQuery .= 'SELECT halt_one , halt_two FROM ' . $name;
    //if there more tables to be joined
    if ($currentCount < count($tableList)) {
        $finalQuery .= ' UNION ';
    }
    $currentCount += 1;
}

//connect the query and retrieve the result
$result = $conn->query($finalQuery);
$locationList = array();

//this process will create an array of locations
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $halt_one = $row["halt_one"];
        $halt_two = $row["halt_two"];

        if (!in_array($halt_one , $locationList)){
            array_push($locationList , $halt_one);
        }
        elseif (!in_array($halt_two , $locationList)){
            array_push($locationList , $halt_two);
        }
    }
}
echo "";
//return the location list array
