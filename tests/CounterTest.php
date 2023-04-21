<?php
use Tanzar\Counter\Counter;
use PHPUnit\Framework\TestCase;

class CounterTest extends TestCase{

    public function testConstructorArguments(){
        $this->constructorTest(0, 0, 5, 5);

        $this->constructorTest(-5, 0, 10, 10);

        $this->constructorTest(0, 0, PHP_INT_MAX, PHP_INT_MAX - 1);
    }

    private function constructorTest(int $startValue, int $expectedStart, int $limit, int $expectedLimit){
        $counter = new Counter($startValue, $limit);

        $setStart = $counter->getState();

        $this->assertEquals($expectedStart, $setStart);

        $setState = $counter->getState();

        $this->assertEquals($expectedStart, $setState);

        $setLimit = $counter->getLimit();

        $this->assertEquals($expectedLimit, $setLimit);
    }

    public function testIncrease() {
        $counterToOne = new Counter(0, 1);

        $this->multipleIncreasesTest($counterToOne, 0, 1);

        $counterToTen = new Counter(0, 10);

        $this->multipleIncreasesTest($counterToTen, 0, 10);

        $counterFromFiveToTen = new Counter(5, 10);

        $this->multipleIncreasesTest($counterFromFiveToTen, 5, 10);
    }

    private function multipleIncreasesTest(Counter $counter, int $start, int $limit){
        for($i = $start; $i <= $limit; $i++){
            $expected = $i + 1;
            if($expected > $limit){
                $expected = $start;
            }
            $this->increaseTest($counter, $expected);
        }
    }

    private function increaseTest(Counter $counter, int $expected) {
        $counter->increase();

        $state = $counter->getState();

        $this->assertEquals($expected, $state);
    }

    public function testFillingCounter() {
        $binaryCounter = new Counter(0, 1);
        
        $first = $binaryCounter->increase();

        $this->assertFalse($first);

        $second = $binaryCounter->increase();

        $this->assertTrue($second);

    }

    public function testReset() {
        $counter = new Counter(0, 5);

        $counter->increase();
        $counter->increase();

        if($counter->getState() !== 0){
            $counter->reset();
            $state = $counter->getState();
            $this->assertEquals(0, $state);
        }
        else{
            $this->assertFalse(true, 'Counter not counting, fix increase() method first.');
        }
    }

}