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
     * @expectedException \Collections\InvalidOperationException
     */
    public function testPopUnderFlow()
    {
        $stack = new Stack();
        $stack->pop();
    }
}
