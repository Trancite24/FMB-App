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
        // traverse from target to source
        while (isset($pi[$u]) && $pi[$u]) {
            $S->push($u);
            $dist += $this->graph[$u][$pi[$u]]; // add distance to predecessor
            $u = $pi[$u];
        }

        // stack will be empty if there is no route back
        if ($S->isEmpty()) {
            echo "No route from $source to $target";
        }
        else {
            // add the source node and print the path in reverse
            // (LIFO) order
            $S->push($source);
            echo "$dist:";
            $sep = '';
            foreach ($S as $v) {
                echo $sep, $v;
                $sep = '->';
            }
            echo "n";
        }
    }
}