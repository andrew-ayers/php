<?php

class Lexer {
    private $common;
    private $operators;
    private $symbols;
    private $tokens;

    public function __construct($array) {
        if (is_array($array) && count($array) > 0) {
            $this->common = new Common();

            $this->operators = explode(',', OPERATORS);

            $this->tokens = array();
            $this->symbols = $array;

            $this->tokenize();
        }
        else {
            throw new Exception("An invalid input was passed to the lexer");
        }
    }

    public function get() {
        return $this->tokens;
    }

    private function tokenize() {
        foreach ($this->symbols as $line => $symbol) {
            if ($symbol == '}') continue;

            $found = false;

            foreach ($this->common->statements as $check) {
                if (substr($symbol, 0, strlen($check)) == $check) {
                    $found = true;

                    break;
                }
            }

            if (!$found) {
                if (substr($symbol, -1) == '{') {
                    $symbol = ltrim(rtrim(substr($symbol, 0, -1)));

                    $method = "tokenize_label";

                    $this->$method($line, $symbol);
                }
                else {
                    throw new Exception("An invalid statement was found: " . $symbol);
                }
            }
        }

        foreach ($this->common->order as $order) {
            if (!empty($order['match'])) {
                $part = $order['label'];
                $check = $order['match'];

                foreach ($this->symbols as $line => $symbol) {
                    if (substr($symbol, 0, strlen($check)) == $check) {
                        $symbol = ltrim(rtrim(str_replace($check, '', $symbol)));

                        $method = "tokenize_" . $check;

                        $this->$method($line, $symbol);
                    }
                }
            }
        }

        ksort($this->tokens);

        $this->tokens = array_values($this->tokens);
    }

    /******************************************************************************************************************/

    private function find_token_closure($start) {
        $count = 0;

        foreach ($this->symbols as $line => $symbol) {
            if ($line >= $start) {
                $symbol=ltrim(rtrim($symbol));

                if (substr($symbol, -1) == '{') {
                    $count++;
                }
                elseif (substr($symbol, -1) == '}') {
                    $count--;

                    if ($count == 0) break;
                }
            }
        }

        return $line + 1;
    }

    private function tokenize_ops($ops) {
        // NOTE: This method should be considered a placeholder method for now; it needs
        // to parse the $ops string by operations order and parentheses grouping

        $lop = '';
        $op = '';
        $rop = '';

        foreach ($this->operators as $check_op) {
            if ($pos = strpos($ops, $check_op)) {
                $op = $check_op;
                $lop = ltrim(rtrim(substr($ops, 0, $pos)));
                $rop = ltrim(rtrim(substr($ops, $pos + 1)));
                break;
            }
        }

        if (empty($op)) return $ops;

        foreach ($this->operators as $check_op) {
            if (strpos($lop, $check_op)) {
                $lop = $this->tokenize_ops($lop);
                break;
            }
        }

        foreach ($this->operators as $check_op) {
            if (strpos($rop, $check_op)) {
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

    private function add_token_item($line, $item) {
        $line = (int) $line;
        $item = (array) $item;

        if (empty($this->tokens[$line])) return $item;

        return array_merge($this->tokens[$line], $item);
    }

    /******************************************************************************************************************/
    /* Individual command tokenizer methods below
    /******************************************************************************************************************/

    private function tokenize_else($line, $ops) {
        $closure = (int) $this->find_token_closure($line);

        $this->tokens[$closure] = $this->add_token_item(
            $closure,
            array(
                'then-to' => hash("crc32", $closure)
            )
        );

        $this->tokens[$line] = $this->add_token_item(
            $line,
            array(
                'token' => TKN_ELSE,
                'then-from' => hash("crc32", $closure)
            )
        );
    }

    private function tokenize_end($line, $ops) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_END
            );
        }
        else {
            throw new Exception("An invalid operation occurred @ line " . $line);
        }
    }

    private function tokenize_gosub($line, $label) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_GOSUB,
                'label' => hash("crc32", $label)
            );
        }
        else {
            throw new Exception("An invalid sub label was found: " . $label);
        }
    }

    private function tokenize_goto($line, $label) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_GOTO,
                'label' => hash("crc32", $label)
            );
        }
        else {
            throw new Exception("An invalid sub label was found: " . $label);
        }
    }

    private function tokenize_if($line, $ops) {
        $closure = (int) $this->find_token_closure($line);

        $this->tokens[$closure] = $this->add_token_item(
            $closure,
            array(
                'token' => TKN_ELSE,
                'else-to' => hash("crc32", $closure)
            )
        );

        $this->tokens[$line] = $this->add_token_item(
            $line,
            array(
                'token' => TKN_IF,
                'ops' => $this->tokenize_ops(substr($ops, 0, -1)),
                'else-from' => hash("crc32", $closure)
            )
        );
    }

    private function tokenize_label($line, $label) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_LABEL,
                'label' => hash("crc32", $label)
            );
        }
        else {
            throw new Exception("A duplicate sub label was found @ line " . ($line + 1) . ": " . $label);
        }
    }

    private function tokenize_let($line, $ops) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_LET,
                'ops' => $this->tokenize_ops($ops)
            );
        }
        else {
            throw new Exception("An invalid operation occurred @ line " . $line);
        }
    }

    private function tokenize_print($line, $ops) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_PRINT,
                //'ops' => $ops //$this->tokenize_ops($ops) <-- need to make this work
                'ops' => $this->tokenize_ops($ops)
            );
        }
        else {
            throw new Exception("An invalid operation occurred @ line " . $line);
        }
    }

    private function tokenize_return($line, $ops) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_RETURN
            );
        }
        else {
            throw new Exception("An invalid operation occurred @ line " . $line);
        }
    }
}