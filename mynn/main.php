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
print_r($network->export());
//print_r($network);

print "\n";