<?php
namespace common;

class Queue {
    /** @var array<mixed> */
    private $queue;

    public function __construct() {
        $this->queue = [];
    }

    /**
    * @param array<mixed> $option
    */
    public function push($option, int $value = NULL) {
        array_push($this->queue, [
            "option"=>$option, 
            "value"=>$value
        ]);
        if($value !== NULL) {
            // echo "<hr>";
            // echo "sorting";
            // sort($this->queue);
            array_multisort(array_column($this->queue, "value"), SORT_ASC, $this->queue);
            // print_r($this->queue);
            // echo "<hr>";
        }
    }

    public function pop() {
        if ($this->isNotEmpty()) {
            return array_pop($this->queue)['option'];
        }
        return null;
    }

    public function shift() {
        if ($this->isNotEmpty()) {
            return array_shift($this->queue)['option'];
        }
        return null;
    }

    public function isNotEmpty(): bool {
        return !empty($this->queue);
    }

    public function isEmpty() {
        return empty($this->queue);
    }
}