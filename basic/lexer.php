<?php

class Lexer {
    private $commands;
    private $ops;

    private $tokens;
    private $labels;
    private $bstack;
    private $last_if;
    private $last_else;
    private $last_label;

    private $else_start;
    private $else_end;

    private $apos;

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
        $this->apos = 0;

        $this->tokens = array();
        $this->labels = array();

        $this->bstack = array();
        $this->last_if = 0;
        $this->last_else = 0;

        $this->last_label = '';

        $this->else_start = 0;
        $this->else_end = 0;

        $this->tokens = $this->tokenize_block($array);

        /*
        foreach ($array as $key => $item) {
            if ($item == '}') {
                if (count($this->bstack) > 0) {
                    $branch = $this->bstack[count($this->bstack) - 1];

                    if ($this->tokens[$branch]['token'] == 16) { // THEN BRANCH
                        $this->last_if = $branch;
                        $this->tokens[$this->last_if]['else'] = $key;
                        //$this->tokens[$this->last_if]['end'] = $key;
                    }

                    if ($this->tokens[$branch]['token'] == 8) { // ELSE BRANCH
                        $this->tokens[$this->last_if]['end'] = $key;
                    }

                    array_pop($this->bstack);
                }

                continue;
            }

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
                if (substr($item, -1) == '{') {
                    $method = "tokenize_label";
                    $ops = ltrim(substr($item, 0, -1));

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

                $token['line'] = $this->labels[$label];
            }
        }
        */
    }

    private function tokenize_block($array) {
        $tokens = array();

        $if_start = 0;
        $if_end = 0;
        $else_start = 0;
        $else_end = 0;

        while ($item = $array[$this->apos++]) {
            if ($item == '}') return $tokens;

            $found = false;

            foreach ($this->commands as $check) {
                if (substr($item, 0, strlen($check)) == $check) {
                    $method = "tokenize_" . $check;
                    $ops = str_replace($check, '', $item);

                    $tokens[] = $this->$method($ops);

                    if (in_array($check, array('if', 'else'))) {
                        if ($check == 'if') {
                            $if_start = count($tokens) - 1;
                        }

                        if ($check == 'else') {
                            $else_start = count($tokens) - 1;
                        }

                        $tokens = array_merge($tokens, $this->tokenize_block($array));

                        if ($check == 'if') {
                            $if_end = count($tokens);

                            $this->else_start++;

                            $tokens[$if_start]['if_else'] = 'else-start-' . $this->else_start;

                        }

                        if ($check == 'else') {
                            $else_end = count($tokens);

                            $this->else_end++;

                            $tokens[$if_end]['if_end'] = 'else-end-' . $this->else_end;
                            $tokens[$else_start]['else_start'] = 'else-start-' . $this->else_start;
                            $tokens[$else_end]['else_end'] = 'else-end-' . $this->else_end;
                        }
                    }

                    $found = true;

                    break;
                }
            }

            if (!$found) {
                if (substr($item, -1) == '{') {
                    $method = "tokenize_label";
                    $ops = ltrim(substr($item, 0, -1));

                    $tokens[] = $this->$method($ops);

                    $tokens = array_merge($tokens, $this->tokenize_block($array));
                }
                else {
                    throw new Exception("An invalid command was found: " . $item);
                }
            }
        }

        return $tokens;
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
            'left' => $lop,
            'op' => $op,
            'right' => $rop
        );
    }

    /******************************************************************************************************************/
    /* Individual command tokenizer methods below
    /******************************************************************************************************************/

    private function tokenize_else($ops) {


        //array_push($this->bstack, count($this->tokens));

        //$this->last_else = count($this->tokens);

        return array(
            'token' => IFELSE,
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
        //$this->last_if = count($this->tokens);

        //array_push($this->bstack, count($this->tokens));

        return array(
            'token' => IFTHEN,
            'ops' => $this->tokenize_ops(substr($ops, 0, -1))
        );
    }

    private function tokenize_label($ops) {
        $label = ltrim(rtrim($ops));

        //$this->last_label = $label;

        //$this->labels[$label] = count($this->tokens);

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
        );
    }
}