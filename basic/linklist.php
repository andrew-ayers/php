<?php

class ListNode {
    private $key;
    private $data;

    private $next;
    private $prev;

    public function __construct($data) {
        $this->prev = NULL;
        $this->next = NULL;

        $this->set_key();

        $this->data = $data;
    }

    public function set_prev($prev) {
        $this->prev = $prev;
    }

    public function get_prev() {
        return $this->prev;
    }

    public function set_next($next) {
        $this->next = $next;
    }

    public function get_next() {
        return $this->next;
    }

    public function set_key($key = null) {
        if (empty($key)) {
            $key = uniqid();
        }

        $this->key = $key;
    }

    public function get_key() {
        return $this->key;
    }

    public function get_data() {
        return $this->data;
    }

    public function set_data($data) {
        $this->data = $data;
    }

    public function get() {
        return $this;
    }
}

class LinkList {
    private $curr;

    private $head;
    private $tail;

    private $count;

    public function __construct() {
        $this->curr = null;
        $this->head = null;
        $this->tail = null;

        $this->count = 0;
    }

    public function is_empty() {
        return ($this->head == null);
    }

    public function node_count() {
        return $this->count;
    }

    public function get_list() {
        $list = array();
        $curr = $this->head;

        while (!empty($curr)) {
            array_push($list, $curr->get_data());

            $curr = $curr->next;
        }

        return $list;
    }

    public function goto_head() {
        $this->curr = $head;
    }

    public function goto_tail() {
        $this->curr = $tail;
    }

    public function goto_next() {
        $curr = $this->curr;

        $this->curr = $curr->get_next();
    }

    public function goto_prev() {
        $curr = $this->curr;
        $this->curr = $curr->get_prev();
    }

    public function goto_node($search, $by_key = true) {
        $this->goto_head();

        while (true) {
            $curr = $this->curr;

            $check = $by_key ? $curr->get_key() : $curr->get_data();

            if ($check == $search) break;

            $this->goto_next();
        }
    }

    public function add($data) {
        if (!empty($this->curr)) {
            $this->insert($data);
        }
        else {
            $this->curr = new ListNode($data);
        }

        $curr = $this->curr;

        return $curr->get_key();
    }

    public function insert($data) {
        $curr = $this->curr;

        if (!empty($curr)) {
            $prev = $curr->get_prev();
            $next = $curr->get_next();

            $node = new ListNode($data);

            $node->set_prev($curr);
            $node->set_next($next);

            $curr = $this->curr = $node;

            return $curr->get_key();
        }
        else {
            return $this->add($data);
        }
    }

    public function delete() {
        $curr = $this->curr;

        $prev = $curr->get_prev();
        $next = $curr->get_next();

        $curr->set_prev($prev);
        $curr->set_next($next);

        $this->curr = $prev;
    }
}