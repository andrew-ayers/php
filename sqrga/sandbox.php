<?php

class Sandbox {
    private $actors = array();
    private $population = 1000;
    private $generations = 1000;
    private $breeders = 100;
    private $mutation_chance = 50;

    public function __construct() {
        for ($i = 0; $i < $this->population; $i++) {
            $actor = new Actor();

            $actor->init();

            $this->actors[] = $actor;
        }

        //print_r($this->actors[0]);
        //die();
    }

    public function run() {
        for ($i = 0; $i < $this->generations; $i++) {
            echo "Working on generation " . $i . "...";
            $this->evaluate();
            //$this->breed();
            //$this->divide();
            $this->mutate();
            echo "Done.\n";
        }
    }

    public function evaluate() {
        $problem = mt_rand(1, 100);

        $solution = sqrt($problem);

        for ($i = 0; $i < $this->population; $i++) {
            $this->actors[$i]->evaluate($problem, $solution);
        }
    }

    private function breed() {
        // order the population into most to least fit
        $this->actors = $this->get_best_fit($this->population);

        // build breeding pair arrays
        $half = ($this->breeders / 2);

        $breeders_a = array_slice($this->actors, 0, $half);
        $breeders_b = array_slice($this->actors, $half - 1, $half);

        // clear out the population and rebuild it from the best fit
        $this->actors = array();

        while (count($this->actors) < $this->population) {
            // mix 'em up
            shuffle($breeders_a);
            shuffle($breeders_b);

            for ($i = 0; $i < $half; $i++) {
                // for each the pair of breeders
                $breeder_a = $breeders_a[$i];
                $breeder_b = $breeders_b[$i];

                // get each breeder's code
                $code_a = $breeder_a->get_code();
                $code_b = $breeder_b->get_code();

                // find a random spot in the code for one
                $pos = mt_rand(0, strlen($code_a));

                // ...and the length from that spot to the end of the other
                $remainder_b = strlen(substr($code_b, $pos - 1));

                // ...then get a parts of each length of code
                $part_a = substr($code_a, 0, $pos);
                $part_b = substr($code_b, $pos, $remainder_b - 1);

                // ...and build the new "child" from parts
                $actor = new Actor();

                $actor->init($part_a . $part_b);

                $this->actors[] = $actor;
            }
        }
    }

    private function divide() {
        // order the populating into most to least fit
        $this->actors = $this->get_best_fit($this->population);

        // get most fit actors to divide
        $dividers = array_slice($this->actors, 0, $this->breeders);

        // clear out the population and rebuild it from the best fit
        $this->actors = array();

        while (count($this->actors) < $this->population) {
            // mix 'em up
            shuffle($dividers);

            for ($i = 0; $i < $this->breeders; $i++) {
                $actor_a = new Actor();
                $actor_b = new Actor();

                // create two copies of code
                $code_a = $code_b = $dividers[$i]->get_code();

                // chance of mutation...
                if (mt_rand(0, 99) >= $this->mutation_chance) {
                    // find a random spot in the code
                    $pos = mt_rand(0, strlen($code_a));

                    $symbol = substr($actor_a->symbols, mt_rand(0, strlen($actor_a->symbols) - 1), 1);

                    $code_a = substr_replace($code_a, $symbol, $pos, 1);
                }

                // chance of mutation...
                if (mt_rand(0, 99) >= $this->mutation_chance) {
                    // find a random spot in the code
                    $pos = mt_rand(0, strlen($code_b));

                    $symbol = substr($actor_b->symbols, mt_rand(0, strlen($actor_b->symbols) - 1), 1);

                    $code_b = substr_replace($code_b, $symbol, $pos, 1);
                }

                // insert the code into each
                $actor_a->init($code_a);
                $actor_b->init($code_b);

                // Update the population
                $this->actors[] = $actor_a;
                $this->actors[] = $actor_b;
            }
        }
    }

    private function mutate() {
        // order the populating into most to least fit
        $this->actors = $this->get_best_fit($this->population);

        // get most fit actors to mutate
        $mutators = array_slice($this->actors, 0, $this->breeders);

        // clear out the population and rebuild it from the best fit
        $this->actors = array();

        while (count($this->actors) < $this->population) {
            // mix 'em up
            shuffle($mutators);

            for ($i = 0; $i < $this->breeders; $i++) {
                $actor = new Actor();

                // get code
                $code = $mutators[$i]->get_code();

                // chance of mutation...
                if (mt_rand(0, 99) >= $this->mutation_chance) {
                    // find a random spot in the code
                    $pos = mt_rand(0, strlen($code));

                    $symbol = substr($actor->symbols, mt_rand(0, strlen($actor->symbols) - 1), 1);

                    $code = substr_replace($code, $symbol, $pos, 1);
                }

                // insert the code
                $actor->init($code);

                // Update the population
                $this->actors[] = $actor;
            }
        }
    }

    public function get_actors() {
        return $this->actors;
    }

    private static function cmp_obj_by_score($a, $b) {
        $a_score = $a->get_score();
        $b_score = $b->get_score();

        if ($a_score == $b_score) return 0;

        return ($a_score < $b_score) ? 1 : -1;
        //return ($a_score < $b_score) ? -1 : 1;
    }

    public function get_best_fit($number = 1) {
        // sort the actors in descending order
        usort($this->actors, array('Sandbox','cmp_obj_by_score'));

        return array_slice($this->actors, 0, $number);
    }
}