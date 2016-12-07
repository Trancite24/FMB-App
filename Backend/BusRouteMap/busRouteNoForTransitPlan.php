<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 9:26 AM
 *
 * This class will create a bus route plan for the
 * sequence of locations given by createPlan.php
 */

include '../TransitPlanner/createPlan.php';
include '../TableHandler/getRouteTableNames.php';
include '../Connection/connection.php';

$routeListWithTime = explode("///" , $route);
$routeListWithTime = array_slice($routeListWithTime , 0 , count($routeListWithTime) -1);

foreach ($routeListWithTime as &$routing){

    $splitStringArray = explode(":" , $routing);
    $time = $splitStringArray[0];
    $routeSequence = explode("->" , $splitStringArray[1]);

    foreach ($tableList as &$name) {

        $finalQuery .= 'SELECT route_id , halt_one , time FROM ' . $name;
        $result = $conn->query($finalQuery);

        //this process will create the Graph required for the transit planner
        if ($result->num_rows > 0) {

            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $route_id = $row["route_id"];
                $halt_one = $row["halt_one"];
                $time = $row["time"];

                for ($x = 0; $x < count($routeSequence); $x++) {

                    if ($routeSequence[$x] == $halt_one){

                    }

                }

                foreach ($routeSequence as &$locationValue){



                }
            }

        }

    }

}

