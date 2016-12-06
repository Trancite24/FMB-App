<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 7:39 AM
 *
 * This class will create a transit planner and returns a sequence of routes
 * with the time needed to go to the destination.
 * inputs: start location, end location
 */

include '../Connection/connection.php';
include './DijkstrasAlgorithm.php';
include '../TableHandler/getRouteTableNames.php';

//this query will be used to retrieve data from the Bus route Tables
$finalQuery = '';
$currentCount = 1;

foreach ($tableList as &$name) {
    $finalQuery .= 'SELECT halt_one , halt_two, time FROM ' . $name;
    //if there more tables to be joined
    if ($currentCount < count($tableList)) {
        $finalQuery .= ' UNION ';
    }
    $currentCount += 1;
}

//connect the query and retrieve the result
$result = $conn->query($finalQuery);
$graph = array();

//this process will create the Graph required for the transit planner
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        $halt_one = $row["halt_one"];
        $halt_two = $row["halt_two"];
        $time = $row["time"];
        //remove the 'mins' part from the database element
        $tempTime = explode(" ", $time);
        $time = $tempTime[0];

        //this part will check whether the key is in the array and ]
        //remove the current list and add a new one
        //if the element is not in the array, add it as a new element
        if (array_key_exists($halt_one, $graph)) {

            $tempArray = $graph[$halt_one];
            if (!array_key_exists($halt_two, $tempArray)) {
                unset($graph[$halt_one]);
                $tempArray[$halt_two] = $time;
                $graph[$halt_one] = $tempArray;
            }
        } else {
            $tempArray = array();
            $tempArray[$halt_two] = $time;
            $graph[$halt_one] = $tempArray;
        }

        if (array_key_exists($halt_two, $graph)) {

            $tempArray = $graph[$halt_two];
            if (!array_key_exists($halt_one, $tempArray)) {
                unset($graph[$halt_two]);
                $tempArray[$halt_one] = $time;
                $graph[$halt_two] = $tempArray;
            }
        } else {
            $tempArray = array();
            $tempArray[$halt_one] = $time;
            $graph[$halt_two] = $tempArray;
        }

    }
} else {
    echo "0 results";
}

$DijkstrasInstance = new DijkstrasAlgorithm($graph);

//get these two points from the request coming in
$start_point = '107 Bus Station, Lower Chatham Street, Colombo, Western Province';
$end_point = 'National Association of Photographers, D. R. Wijewardena Mawatha, Colombo Sri Lanka';

$DijkstrasInstance->calculateShortestPath( $start_point , $end_point );

//return the value back to the front end