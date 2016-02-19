<?php
class Interpreter {
    private $ops;

    private $code;
    private $stack;
    private $heap;

    private $do_branch_then;

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
            case TKN_ELSE:
                $this->pc = $this->do_branch_then ? $this->branch_then($token) : $this->pc;
                break;

            case TKN_END:
                $this->running = false;
                break;

            case TKN_GOSUB:
                $label = $token['label'];
                array_push($this->stack, $this->pc);
                $this->pc = !empty($this->heap[$label]) ? $this->heap[$label] : $this->find_label_pc($label);
                break;

            case TKN_GOTO:
                $this->pc = $token['goto'];
                break;

            case TKN_IF:
                $this->branch_then = true;
                if (!$this->eval_ops($this->token['ops']))
                    $this->pc = $this->branch_else($token);
                break;

            case TKN_LABEL:
                $this->label = $token['ops'];
                break;

            case TKN_LET:
                $var = $this->token['ops']['left'];
                $this->heap[$var] = $this->eval_ops($this->token['ops']);
                break;

            case TKN_PRINT:
                $var = $this->token['ops'];
                echo $this->heap[$var] . "\n";
                break;

            case TKN_RETURN:
                $this->pc = array_pop($this->stack) + 1;
                break;

            default:
                // we should never get here because the lexer should have caught invalid statements/commands
                throw new Exception("WTF?!");
        }
    }

    private function branch_else($token) {
        $this->branch_then = false;

        $else = $token['else-from'];

        foreach($this->code as $key => $token) {
            if ($token['else-to'] == $else) {
                return $key;
            }
        }

        throw new Exception("Malformed Else?");
    }

    private function branch_then($token) {
        $this->do_branch_then = false;

        $then = $token['then-from'];

        foreach($this->code as $key => $token) {
            if ($token['then-to'] == $then) {
                return $key;
            }
        }

        throw new Exception("Malformed Then?");
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