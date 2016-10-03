<?php

namespace Collections;

class StackTest extends \PHPUnit_Framework_TestCase
{
    public function testPush()
    {
        $stack = new Stack();

        $stack->push('one');

        $this->assertEquals(new Stack(['one']), $stack);

        $stack->push('two');

        $this->assertEquals(new Stack(['one', 'two']), $stack);

        $stack->push('three');

        $this->assertEquals(new Stack(['one', 'two', 'three']), $stack);
    }

    public function testPeek()
    {
        $stack = new Stack(['one', 'two', 'three']);

        $result = $stack->peek();

        $this->assertEquals('three', $result);

        $this->assertEquals(new Stack(['one', 'two', 'three']), $stack);
    }

    public function testPop()
    {
        $stack = new Stack(['one', 'two', 'three']);

        $result = $stack->pop();

        $this->assertEquals('three', $result);

        $this->assertEquals(new Stack(['one', 'two']), $stack);

        $result = $stack->pop();

        $this->assertEquals('two', $result);

        $this->assertEquals(new Stack(['one']), $stack);

        $result = $stack->pop();

        $this->assertEquals('one', $result);

        $this->assertEquals(new Stack([]), $stack);
    }

    /**
     * @expectedException \UnderflowException
     */
    public function testPopUnderFlow()
    {
        $stack = new Stack();
        $stack->pop();
    }

    public function testCopyToDefaultBehavior()
    {
        $stack = new Stack(['one', 'two', 'three']);

        $array = [];

        $stack->copyTo($array);

        $this->assertEquals(['one', 'two', 'three'], $array);
    }

    public function testCopyToWithIndexInMiddle()
    {
        $stack = new Stack(['one', 'two', 'three']);

        $array = ['testing', 'testing', 'now', 'done'];

        $stack->copyTo($array, 2);

        $this->assertEquals(['testing', 'testing', 'one', 'two', 'three'], $array);
    }

    public function testCopyToWithIndexAtEnd()
    {
        $stack = new Stack(['one', 'two', 'three']);

        $array = ['testing', 'testing'];

        $stack->copyTo($array, count($array));

        $this->assertEquals(['testing', 'testing', 'one', 'two', 'three'], $array);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testCopyToIndexLessThanZero()
    {
        $array = ['one', 'two', 'three'];

        $stack = new Stack();

        $stack->copyTo($array, -1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCopyToIndexNan()
    {
        $array = ['one', 'two', 'three'];

        $stack = new Stack();

        $stack->copyTo($array, 'j');
    }
}
