<?php
class Interpreter {
    private $ops;

    private $code;
    private $stack;
    private $heap;

    private $pc;
    private $running;

    public function __construct($data) {
        $this->ops = explode(',', OPERATORS);

        $this->clear();

        $this->code = $data;
    }

    public function run() {
        $this->reset(true);

        while($this->running) {
            $this->step();
        }
    }

    public function step() {
        $token = $this->code[$this->pc++];

        switch ($token['cmd']) {
            case ELSIF:
                // ignore token, code continues from here...
                break;

            case END:
                $this->running = false;
                break;

            case GOSUB:
                $label = $token['label'];
                array_push($this->stack, $this->pc);
                $this->pc = !empty($this->heap[$label]) ? $this->heap[$label] : $this->find_label_pc($label);
                break;

            case GOTOO:
                $this->pc = $token['goto'];
                break;

            case IFTHEN:
                if (!$this->eval_ops($this->token['ops']))
                    $this->pc = 0; // find else branch here?
                break;
            //IFELSE ?
            //IFEND ?
            case LABEL:
                $this->label = $token['ops'];
                break;

            case LET:
                //$var = $this->token['ops']['lop'];
                //$val =

                //$this->heap[$var] = $this->eval_ops($this->token['ops']);
                $this->eval_ops($this->token['ops']);
                break;

            case PRNT:
                $var = $this->token['ops'];

                echo $this->heap[$var] . "\n";
                break;

            case RETSUB:
                $this->pc = array_pop($this->stack);
                break;

            default:
                // we should never get here because the lexer should have caught invalid statements/commands
                throw new Exception("WTF?!");
        }
    }

    private function find_label_pc($label) {
        foreach($this->code as $key => $token) {
            if ($token['label'] == $label) {
                $this->heap[$label] = $key; // save return value for pc on the heap for future reference (as needed)

                return $key;
            }
        }

        // we should never get here because the lexer should have caught an invalid label
        throw new Exception("WTF?!");
    }

    private function eval_ops($ops) {
        return false;
    }

    public function reset($running = false) {
        $this->pc = 0;
        $this->running = $running;
    }

    public function clear() {
        $this->reset();

        $this->code = array();
        $this->heap = array();
        $this->stack = array();
    }

    public function dump() {

    }
}