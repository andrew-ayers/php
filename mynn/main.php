<?php
    include_once('includes/network.inc');

    $network = new Network();

    $network->add(4, "Inpt");       // input layer
    $network->add(3, "Sigmoid");    // "hidden" layer
    $network->add(1, "Sigmoid");    // output layer

    //var_dump($network);
    print_r($network->export());

    print "\n";
?>