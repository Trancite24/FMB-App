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
include '../TransitPlanner/DijkstrasAlgorithm.php';
include '../TableHandler/getRouteTableNames.php';

//this query will be used to retrieve data from the Bus route Tables
$finalQuery = '';
$currentCount = 1;

foreach ($tableList as &$name) {
    $finalQuery .= 'SELECT route_id ,halt_one , halt_two, time FROM ' . $name;
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

        $route_id = $row["route_id"];
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
                $tempArray[$halt_two] = $time.':'.$route_id;
                $graph[$halt_one] = $tempArray;
            } else {
                $haltTwoRouteArray = explode("," ,explode(":" , $tempArray[$halt_two])[1]);
                if (!in_array($route_id , $haltTwoRouteArray)){
                    unset($graph[$halt_one]);
                    $tempArray[$halt_two] = $tempArray[$halt_two].",".$route_id;
                    $graph[$halt_one] = $tempArray;
                }
            }
        } else {
            $tempArray = array();
            $tempArray[$halt_two] = $time.':'.$route_id;
            $graph[$halt_one] = $tempArray;
        }

        if (array_key_exists($halt_two, $graph)) {

            $tempArray = $graph[$halt_two];
            if (!array_key_exists($halt_one, $tempArray)) {
                unset($graph[$halt_two]);
                $tempArray[$halt_one] = $time.':'.$route_id;
                $graph[$halt_two] = $tempArray;
            } else {
                $haltOneRouteArray = explode("," ,explode(":" , $tempArray[$halt_one])[1]);
                if (!in_array($route_id , $haltOneRouteArray)){
                    unset($graph[$halt_two]);
                    $tempArray[$halt_one] = $tempArray[$halt_one].",".$route_id;
                    $graph[$halt_two] = $tempArray;
                }
            }
        } else {
            $tempArray = array();
            $tempArray[$halt_one] = $time.':'.$route_id;
            $graph[$halt_two] = $tempArray;
        }

    }
} else {
    echo "0 results";
}

$DijkstrasInstance = new DijkstrasAlgorithm($graph);

//get these two points from the request coming in
$start_point = $_GET['start_point'];
$end_point = $_GET['end_point'];
$currentTime = $_GET['time'];

$route = $DijkstrasInstance->calculateShortestPath( $start_point , $end_point );
echo $_GET['callback']."(".(json_encode($route)).")";
//-------------------------------------------

$timeForJourney = explode(":" , $route)[0];
$routing= explode(":" , $route)[1];

$routing = explode("->" , $routing);

$final_result = array();
array_push($final_result , "timeForJourney:".$timeForJourney);
array_push($final_result , "sequenceForJourney:".explode(":" , $route)[1]);
$temp = "";
$check = false;
$time = 0;
$ultimate_start = "";

foreach ($routing as &$routeValue){

    $start_point = explode("--" , $routeValue)[0];
    $route_no = explode("--" , $routeValue)[1];

    if (!$check){
        $ultimate_start = $start_point;
    }
    if ($temp == $route_no){
        continue;
    } elseif ($check){
        $start_array = get_lat_long($ultimate_start);
        $end_array = get_lat_long($start_point);
        $time .= explode(" ", getTime($start_array[0] ,  $end_array[0] ,$start_array[1] , $end_array[1]))[0];
        $ultimate_start = $start_point;
    }
    $temp = $route_no;
    $timeTablesQuery = "SELECT timetable_name FROM bus_route WHERE route_no = $route_no";
    $result = $conn->query($timeTablesQuery);

    $timetable_name = "";
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $timetable_name = $row["timetable_name"];
    }

    $query = "SELECT start_halt, start_time FROM $timetable_name LIMIT 1";
    $result = $conn->query($query);

    $start_halt = "";
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $start_halt = $row["start_halt"];
        }
    }

    $start_array = get_lat_long($start_halt);
    $end_array = get_lat_long($start_point);

    $time .= explode(" ", getTime($start_array[0] ,  $end_array[0] ,$start_array[1] , $end_array[1]))[0];

    array_push($final_result, $route_no.":".$time);

    $check = true;

}

function getTime($lat1, $lat2, $long1, $long2) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=en-US&key=AIzaSyDq1_JABbF4d85yAUh1psNLxN0xNHyU3rA";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    return $time;
}

function get_lat_long($address) {
    $latlng = array();
    $address = str_replace(" ", "+", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyDq1_JABbF4d85yAUh1psNLxN0xNHyU3rA");
    $json = json_decode($json);
    $latlng[] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $latlng[] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $latlng;
}
