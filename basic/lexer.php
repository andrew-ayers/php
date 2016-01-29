<?php

class Lexer {
    private $commands;
    private $ops;

    private $tokens;
    private $labels;
    private $last_label;

    public function __construct($array) {
        $this->commands = explode(',', COMMANDS);
        $this->ops = explode(',', OPERATORS);

        $this->tokenize($array);

        //die(print_r($this->labels,true));
    }

    public function get() {
        return $this->tokens;
    }

    private function tokenize($array) {
        $this->tokens = array();
        $this->labels = array();
        $this->last_label = '';

        foreach ($array as $item) {
            $found = false;

            foreach ($this->commands as $check) {
                if (substr($item, 0, strlen($check)) == $check) {
                    $method = "tokenize_" . rtrim($check);
                    $ops = str_replace($check, '', $item);

                    $this->tokens[] = $this->$method($ops);

                    $found = true;

                    break;
                }
            }

            if (!$found) {
                if (substr($item, -1) == ':') {
                    $method = "tokenize_label";
                    $ops = substr($item, 0, -1);

                    $this->tokens[] = $this->$method($ops);
                }
                else {
                    throw new Exception("An invalid command was found: " . $item);
                }
            }
        }

        foreach ($this->tokens as &$token) {
            if ($token['token'] == GOTOO) {
                $label = $token['label'];

                //if (empty($this->labels[$label]))
                    //throw new Exception("An invalid label was found: " . $label);

                $token['goto'] = $this->labels[$label];
            }
        }
    }

    private function tokenize_ops($ops) {
        $lop = '';
        $op = '';
        $rop = '';

        foreach ($this->ops as $check_op) {
            if (stristr($ops, $check_op)) {
                $op = $check_op;
                $parts = explode($op, $ops);
                $lop = ltrim(rtrim($parts[0]));
                $rop = ltrim(rtrim($parts[1]));
                break;
            }
        }

        foreach ($this->ops as $check_op) {
            if (stristr($lop, $check_op)) {
                $lop = $this->tokenize_ops($lop);
                break;
            }
        }

        foreach ($this->ops as $check_op) {
            if (stristr($rop, $check_op)) {
                $rop = $this->tokenize_ops($rop);
                break;
            }
        }

        return array(
            'lop' => $lop,
            'op' => $op,
            'rop' => $rop
        );
    }

    /******************************************************************************************************************/
    /* Individual command tokenizers below
    /******************************************************************************************************************/

    private function tokenize_else($ops) {
        return array(
            'token' => ELSIF,
        );
    }

    private function tokenize_end($ops) {
        return array(
            'token' => END,
        );
    }

    private function tokenize_gosub($ops) {
        return array(
            'token' => GOSUB,
            'label' => ltrim(rtrim($ops))
        );
    }

    private function tokenize_goto($ops) {
        return array(
            'token' => GOTOO,
            'label' => ltrim(rtrim($ops))
        );
    }

    private function tokenize_if($ops) {
        return array(
            'token' => IFTHEN,
            'ops' => $this->tokenize_ops(substr($ops, 0, -1))
        );
    }

    private function tokenize_label($ops) {
        $label = ltrim(rtrim($ops));

        $this->last_label = $label;

        $this->labels[$label] = count($this->tokens);

        return array(
            'token' => LABEL,
            'ops' => $label,
        );
    }

    private function tokenize_let($ops) {
        return array(
            'token' => LET,
            'ops' => $this->tokenize_ops($ops)
        );
    }

    private function tokenize_print($ops) {
        return array(
            'token' => PRNT,
            'ops' => ltrim(rtrim($ops)),
        );
    }

    private function tokenize_return($ops) {
        return array(
            'token' => RETSUB,
            'label' => $this->last_label
        );
    }
}