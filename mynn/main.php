<?php
    //include_once('includes/neuron.inc');
    include_once('includes/layer.inc');
    //include_once('includes/network.inc');
    //include_once('includes/tfunction.inc');

    $layer = new Layer(4, 'Binary');

    //var_dump($layer);

    print "\n";

    $layer->randomize();

    var_dump($layer);

    print "\n";
?>