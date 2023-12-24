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
    public function insert($option, int $value = NULL) {
        array_push($this->queue, [
            "option"=>$option, 
            "value"=>$value
        ]);
        if($value !== NULL) {
            // echo "<hr>";
            // echo "sorting";
            // sort($this->queue);
            $data = array_column($this->queue, "value");
            array_multisort($data, SORT_ASC, $this->queue);
            // print_r($this->queue);
            // echo "<hr>";
        }
    }

    /**
     * @return array<mixed>
     */
    public function pop(): array|NULL {
        if ($this->isNotEmpty()) {
            return array_pop($this->queue)['option'];
        }
        return null;
    }

    /**
     * @return array<mixed>
     */

    public function shift(): array|NULL {
        if ($this->isNotEmpty()) {
            return array_shift($this->queue)['option'];
        }
        return null;
    }

    public function isNotEmpty(): bool {
        return !empty($this->queue);
    }

    public function isEmpty():bool {
        return empty($this->queue);
    }

    public function queueSize():int {
        return count($this->queue);
    }

    /**
     * @return array<mixed>
     */
    public function show(): array {
        return ($this->queue);
    }
}