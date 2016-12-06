<?php



//this class overrides the "compare()" function to ensure that the key with the lowest
//distance is given the highest priority
class PriorityQueue extends SplPriorityQueue
{
    public function compare( $priority1, $priority2 )
    {
        if ($priority1 === $priority2) return 0;
        return $priority1 < $priority2 ? 1 : -1;
    }
}

class DijkstrasAlgorithm
{

    protected $graph;

    public function __construct($graph) {
        $this->graph = $graph;
    }

    public function calculateShortestPath($source, $target) {

        //distance array for each vertex
        $d = array();
        // array of predecessors for each vertex
        $pi = array();
        // queue of all unoptimized vertices
        $Q = new PriorityQueue();
        // this will store the sequence of route numbers
        $R = new SplStack();

        //initialization of distance and predecessor
        foreach ($this->graph as $v => $adj) {
            $d[$v] = INF; // set initial distance to "infinity"
            $pi[$v] = null; // no known predecessors yet

            $Q->insert($v , $d[$v]);
        }

        // initial distance at source is 0
        $d[$source] = 0;

        while (!$Q->isEmpty()) {

            // extract node min cost
            $u = $Q->extract();

            //take neighbours of u
            foreach ($this->graph[$u] as $v => $cost) {

                $temp = explode(":", $cost);
                $cost = $temp[0];
                // alternate route length to adjacent neighbor
                $alt = $d[$u] + $cost;
                // if alternate route is shorter
                if ($alt < $d[$v]) {
                    $d[$v] = $alt; // update minimum length to vertex
                    $pi[$v] = $u;  // add neighbor to predecessors
                    $Q->insert($v , $alt);
                }
            }

        }

        // we can now find the shortest path using reverse
        // iteration
        $S = new SplStack(); // shortest path with a stack
        $u = $target;
        $dist = 0;

        //this string will be returned as a result
        $route = '';

        // traverse from target to source
        while (isset($pi[$u]) && $pi[$u]) {
            $S->push($u);
            $dist += $this->graph[$u][$pi[$u]]; // add distance to predecessor
            $u = $pi[$u];
        }

        // stack will be empty if there is no route back
        if ($S->isEmpty()) {
            $route .=  "No route from $source to $target";
        }
        else {
            // add the source node and print the path in reverse
            // (LIFO) order
            $S->push($source);
            $route .= "$dist:";
            $sep = '';
            while (!$S->isEmpty()) {
                $v = $S->pop();
                if (!$S->isEmpty()){
                    $routeNos = explode(":" , $this->graph[$v][$S->top()] )[1];
                    $R->push($routeNos);
                }
                $route .= $sep. $v."--".$routeNos;
                $sep = '->';
            }
            //$route .= "";
        }
        //$this->getRouteList($R);


        return $route;

//        ---------------------------------------------------





    }

    private function getRouteList($R){

        //this will be used to generate an array with required bus routes
        $routeArray = array();
        $var = $R->pop();
        if ($R->count() == 0){
            array_push($routeArray , $var);
        }

        while(!$R->isEmpty()){

            $split = explode(",", $var);
            if (count($split) > 1){

                $tempSplit = explode(",",$R->top());
                if (count($tempSplit) > 1){

                    $var = implode(",",array_unique(array_merge($split,$tempSplit)));

                } else{

                    if (in_array($R->top() , $split)){
                        $var = $R->pop();
                        array_push($routeArray , $var);
                    } else{
                        array_push($routeArray , $split[0]);
                        $var = $R->pop();

                    }
                }

            } else{

                if (!$R->isEmpty()){
                    $tempSplit = explode(",",$R->top());

                    if (count($tempSplit) > 1){
                        if (in_array($var , $tempSplit)){
                            array_push($routeArray , $var);
                            $R->pop();
                        } else{
                            $var = $R->pop();
                        }
                    } else{
                        array_push($routeArray , $var);
                        if ($var != $R->top()){
                            $var = $R->pop();
                            array_push($routeArray ,$var);
                        } else{
                            $var = $R->pop();
                        }
                    }
                } else {
                    array_push($routeArray , $var);
                }
            }
        }
        $routeArray = array_reverse($routeArray);
        $routeArray = $this->removeRepeatedRoutes($routeArray);
    }

    private function removeRepeatedRoutes($routeArray){

        $temp = $routeArray[0];
        $tempArray = array();
        array_push($tempArray , $temp);
        for ($x = 1; $x < count($routeArray); $x++) {

            if ($temp != $routeArray[$x]){
                array_push($tempArray , $routeArray[$x]);
                $temp = $routeArray[$x];
            }

        }
        return $tempArray;
    }
}

