<?php
use Tanzar\Counter\Counter;
use Tanzar\Counter\MultiCounter;
use PHPUnit\Framework\TestCase;

class MultiCounterTest extends TestCase {

    public function testBinaryFourDigits() {
        $counter = new MultiCounter();

        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));

        $iterationsStates = [
            2 => [0 => 0, 1 => 0, 2 => 1, 3 => 0],
            5 => [0 => 0, 1 => 1, 2 => 0, 3 => 1],
            10 => [0 => 1, 1 => 0, 2 => 1, 3 => 0],
            14 => [0 => 1, 1 => 1, 2 => 1, 3 => 0]
        ];

        $this->counterIterationTest($counter, $iterationsStates, 16);
    }

    public function testCustomCounters() {
        $counter = new MultiCounter();

        $counter->addCounter(new Counter(0, 5));
        $counter->addCounter(new Counter(3, 6));
        $counter->addCounter(new Counter(-3, 1));
        $counter->addCounter(new Counter(3, 5));
        
        $iterationsStates = [
            0 => [0 => 0, 1 => 3, 2 => 0, 3 => 3],
            5 => [0 => 0, 1 => 3, 2 => 1, 3 => 5],
            10 => [0 => 0, 1 => 4, 2 => 1, 3 => 4],
            24 => [0 => 1, 1 => 3, 2 => 0, 3 => 3],
            30 => [0 => 1, 1 => 4, 2 => 0, 3 => 3],
            48 => [0 => 2, 1 => 3, 2 => 0, 3 => 3],
            144 => [0 => 0, 1 => 3, 2 => 0, 3 => 3]
        ];

        $this->counterIterationTest($counter, $iterationsStates, 150);
    }

    public function testReset(){
        $counter = new MultiCounter();

        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));

        $startState = $counter->getState();

        for($i = 0; $i <= 10; $i++){
            $counter->increase();
        }

        $counter->reset();

        $resetedState = $counter->getState();

        $this->assertEquals($startState, $resetedState);
    }

    public function testFillingCounter(){
        $counter = new MultiCounter();

        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));
        $counter->addCounter(new Counter(0, 1));

        for($i = 0; $i <= 14; $i++){
            $counter->increase();
        }

        $reseted = $counter->increase();

        $this->assertTrue($reseted, 'State: ' . json_encode($counter->getState()));
    }

    private function counterIterationTest(MultiCounter $counter, $iterationsStates, int $iterations) {
        for($iteration = 0; $iteration <= $iterations; $iteration++){
            if(isset($iterationsStates[$iteration])){
                $expected = $iterationsStates[$iteration];
                $state = $counter->getState();
                $this->assertEquals($expected, $state, 'Iteration: ' . $iteration);
            }
            $counter->increase();
        }
    }
}