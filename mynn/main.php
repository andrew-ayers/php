<?php
/**
 * Simple MyANN neural network setup example for testing
 */

include_once('includes/network.inc');

// Instantiate the network
$network = new Network();

// Build three different layers
$network->add(4, "Inpt");       // input layer
$network->add(3, "Sigmoid");    // "hidden" layer
$network->add(1, "Sigmoid");    // output layer

// Do stuff here
$dump1 = $network->export();

print_r($dump1);

print "\n\n";

$network2 = new Network();

$network2->import($dump1);

/*
$dump2 = $network->export();

print_r($dump2);

print "\n\n";

print_r(($dump1 == $dump2));

print "\n";
*/