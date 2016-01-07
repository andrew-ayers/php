<?php

class Actor {
    private $code = '';
    private $max_size = 1000;
    private $score = 0;
    private $breed = 0;

    public $symbols = '+-*/!'; // '+-*/%!';

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

    public function evaluate($problem, $solution = null) {
        $answer = (float) $problem;

        $code_length = strlen($this->code);
        for ($i=0; $i < $code_length; $i++) {
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

        // only calculate a solution if needed
        if (!empty($solution)) {
            // lower scores are better scores
            $this->score = (abs((float) $solution - $answer) / $solution);

            // to score on shorter code
            $this->score = $this->score * $code_length;
        }

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