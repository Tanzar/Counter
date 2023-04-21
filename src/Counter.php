<?php

namespace Tanzar\Counter;

class Counter {
    private int $startValue = 0;
    private int $limit = 1;
    private int $state = 0;

    /**
     * Constructor for Counter, arguments have default values but it is recommended to define your own here
     *
     * @param int $startValue
     * @param int $limit
     * 
     */
    public function __construct(int $startValue = 0, int $limit = PHP_INT_MAX - 1){
        $start = max(0, min($startValue, (PHP_INT_MAX - 1)));
        $this->startValue = $start;
        $this->state = $start;
        $this->limit = max(1, min($limit, (PHP_INT_MAX - 1)));
    }

    
    public function increase() : bool {
        $this->state++;
        if($this->state > $this->limit){
            $this->state = $this->startValue;
            return true;
        }
        else{
            return false;
        }
    }

    
    public function reset() : void {
        $this->state = $this->startValue;
    }

    public function getLimit() : int {
        return $this->limit;

    }

    public function getState() : int {
        return $this->state;
    }
}