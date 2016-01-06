<?php

class Actor {
    private $code = '';
    private $max_size = 100;
    private $score = 0;
    private $breed = 0;

    public $symbols = '+-*/'; // '+-*/%!';

    public function __construct($code = null) {}

    public function init($code = null) {
        if (empty($code)) {

            for ($i = 0; $i < $this->max_size; $i++) {
                $symbol = substr($this->symbols, mt_rand(0, strlen($this->symbols) - 1), 1);
                $this->code .= $symbol;
                if ($symbol == '!') break;
            }
        }
        else {
            $this->code = substr($code, 0, $this->max_size);
        }
    }

    public function evaluate($problem, $solution) {
        $answer = 0.0;

        for ($i=0; $i < strlen($this->code); $i++) {
            $operation = substr($this->code, $i, 1);

            switch ($operation) {
                case '+':
                    $answer += 1.0;
                    break;
                case '-':
                    $answer -= 1.0;
                    break;
                case '*':
                    $answer *= 2.0;
                    break;
                case '/':
                    $answer /= 2.0;
                    break;
                case '%':
                    $answer %= 2.0;
                    break;
                case '!':
                    break 2;
            }
        }

        $this->score = (abs((float) $solution - $answer) / $solution) * 100.0; // the closer to zero, the better

        //print_r($answer);
        //echo "\n";
        return (float) $answer;
    }

    public function get_code() {
        return $this->code;
    }

    public function set_code($code) {
        $this->code = $code;
    }

    public function get_breed() {
        return $this->breed;
    }

    public function set_breed($breed) {
        $this->breed = $breed;
    }

    public function get_score() {
        return $this->score;
    }
}