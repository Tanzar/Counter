<?php

namespace Counter;

class MultiCounter{
    private array $counters;

    public function __construct(){
        $this->counters = [];
    }

    public function addCounter(Counter $counter, bool $addToEnd = true) : void {
        if($addToEnd){
            $this->counters[] = $counter;
        }
        else{
            array_unshift($this->counters, $counter);
        }
    }

    public function increase() : bool {
        $lastIndex = count($this->counters) - 1;
        if($lastIndex > -1){
            return $this->increment($lastIndex);
        }
        return false;
        
    }

    private function increment(int $index) : bool {
        $filled = $this->getCounter($index)->increase();
        if($index === 0 && $filled){
            $this->reset();
            return true;
        }
        elseif($filled){
            return $this->increment($index - 1);
        }
        return false;
    }

    private function getCounter(int $index) : Counter{
        return $this->counters[$index];
    }

    public function getState() : array {
        $states = [];
        foreach($this->counters as $index => $counter){
            $state = $counter->getState();
            $states[$index] = $state;
        }
        return $states;
    }

    public function reset() : void {
        foreach($this->counters as $counter){
            $counter->reset();
        }
    }
}