<?php

class Lexer {
    private $common;
    //private $conditionals;
    //private $commands;
    private $ops;

    private $symbols;
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
        if (is_array($array) && count($array) > 0) {
            $this->common = new Common();

            $this->ops = explode(',', OPERATORS);

            $this->tokens = array();
            $this->symbols = $array;

            $this->tokenize();
        }
        else {
            // error?
        }
    }

    public function get() {
        return $this->tokens;
    }

    private function tokenize() {
        $this->tokenize_symbols();

        //$this->tokens = $this->tokenize_block($array);

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

    private function tokenize_symbols() {
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
    }







    /******************************************************************************************************************/
















    private function tokenize_block($block) {
        $tokens = array();

        for ($i = 0; $i < count($block); $i++) {
            $item = $block[$i];

            //if ($item == '}') return $tokens;

            $found = false;

            for ($j = 0; $j < count($this->commands); $j++) {
                $check = $this->commands[$j];

                if (substr($item, 0, strlen($check)) == $check) {
                    $found = true;

                    $method = "tokenize_" . $check;
                    $ops = str_replace($check, '', $item);

                    $tokens[] = $this->$method($ops);

                    break;
                }
            }

            if (!$found) {
                if (substr($item, -1) == '{') {
                    $method = "tokenize_label";

                    $ops = ltrim(substr($item, 0, -1));

                    $tokens[] = $this->$method($ops);

                    for ($k = $i + 1; $k < count($block); $k++) {
                        if ($block[$k] == '}') break;
                        $new_block[] = $block[$k];
                    }
                    //$new_block = array_slice($block, $i + 1);

                    //throw new Debug(999, "YOLO", $new_block);

                    $new_tokens = $this->tokenize_block($new_block);

                    $tokens = array_merge($tokens, $new_tokens);
                }
                else {
                    if ($item != '}')
                        throw new Exception("An invalid command was found: " . $item);
                }
            }
        }

        return $tokens;
    }












    private function tokenize_block_OLD($array) {
        $tokens = array();

        $apos = $if_block_apos = $else_block_apos = $end_block_apos = 0;

        while ($item = $array[$apos]) {
            if ($item == '}') return $tokens;

            $found = false;

            foreach ($this->commands as $check) {
                if (substr($item, 0, strlen($check)) == $check) {
                    $found = true;

                    $method = "tokenize_" . $check;
                    $ops = str_replace($check, '', $item);

                    $tokens[] = $this->$method($ops);

                    if ($check == 'if') {
                        $if_block_apos = $apos;

                        $else_block_apos = $end_block_apos = 0;

                        while ($fitem = $array[$apos++]) {
                            if ($fitem == '}') {
                                $else_block_apos = $end_block_apos = $apos;

                                break;
                            }
                        }

                        $item = $array[$apos++];

                        if (substr($item, 0, strlen('else')) == 'else') {
                            while ($eitem = $array[$apos++]) {
                                if ($eitem == '}') {
                                    $end_block_apos = $apos;

                                    break;
                                }
                            }
                        }
                    }

                    break;
                }
            }

            if ($found) {
                /*
                if ((($else_block['start'] - 1) != $if_block['end']) && $else_block['start'] != 0) {
                    throw new Exception("An 'else-before-if' error ocurred: " . $item);
                }
                */

                if ($else_block_apos > $if_block_apos) {
                    $start = $if_block_apos + 1;
                    $end = $else_block_apos - 1;

                    $temp_array = array_slice($array, $start, $end - $start);

                    //throw new Debug(999, "START=" . $start . ", END=" . $end);
                    //throw new Debug(999, "APOS=" . $apos, $array);
                    //throw new Debug(999, "APOS=" . $apos, $temp_array);

                    $tokens = array_merge($tokens, $this->tokenize_block($temp_array));
                    //throw new Debug(999, "APOS=" . $apos, $tokens);
                }

                if ($end_block_apos > $else_block_apos) {
                    $start = $else_block_apos + 1;
                    $end = $end_block_apos - 1;

                    $temp_array = array_slice($array, $start, $end - $start);

                    //throw new Debug(999, "START=" . $start . ", END=" . $end);
                    //throw new Debug(999, "APOS=" . $apos, $array);
                    //throw new Debug(999, "APOS=" . $apos, $temp_array);

                    $tokens = array_merge($tokens, $this->tokenize_block($temp_array));
                    //throw new Debug(999, "APOS=" . $apos, $tokens);
                }
            }
            else {
                if (substr($item, -1) == '{') {
                    $method = "tokenize_label";

                    $ops = ltrim(substr($item, 0, -1));

                    $tokens[] = $this->$method($ops);

                    $apos++;

                    $temp_array = array_slice($array, $apos);

                    //throw new Debug(999, "APOS=" . $apos, $array);
                    //throw new Debug(999, "APOS=" . $apos, $temp_array);

                    $tokens = array_merge($tokens, $this->tokenize_block($temp_array));
                    //throw new Debug(999, "APOS=" . $apos, $tokens);
                }
                else {
                    throw new Exception("An invalid command was found: " . $item);
                }
            }

            $apos++;
        }

        return $tokens;
    }









    /******************************************************************************************************************/

    private function find_token_closure($start) {
        $count = 1;

        foreach ($this->symbols as $line => $symbol) {
            if ($line > $start) {
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

        return $line;
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

    private function tokenize_else($line, $ops) {
        //if (empty($this->tokens[$line])) {
            $closure = (int) $this->find_token_closure($line) + 1;

            $label = $closure . '-' . $ops;

            $this->tokens[$closure] = array_merge($this->tokens[$closure],
                array(
                    'end-to' => md5($label)
                )
            );

            $this->tokens[$line] = array(
                'token' => TKN_ELSE,
                'end-from' => md5($label)
            );
        //}
        //else {
        //    throw new Exception("An invalid operation occurred @ line " . $line);
        //}
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
                'label' => md5($label)
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
                'label' => md5($label)
            );
        }
        else {
            throw new Exception("An invalid sub label was found: " . $label);
        }
    }

    private function tokenize_if($line, $ops) {
        //if (empty($this->tokens[$line])) {
            $closure = (int) $this->find_token_closure($line) + 1;

            $label = $closure . '-' . $ops;

            $this->tokens[$closure] = array(
                'els'=> $label,
                'else-to' => md5($label)
            );

            $this->tokens[$line] = array(
                'token' => TKN_IF,
                'ops' => $this->tokenize_ops(substr($ops, 0, -1)),
                'els'=> $label,
                'else-from' => md5($label)
            );
        //}
        //else {
        //    throw new Exception("An invalid operation occurred @ line " . $line);
        //}
    }

    private function tokenize_label($line, $label) {
        if (empty($this->tokens[$line])) {
            $this->tokens[$line] = array(
                'token' => TKN_LABEL,
                'label' => md5($label)
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
                'ops' => $ops //$this->tokenize_ops($ops) <-- need to make this work
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