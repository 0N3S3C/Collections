<?php

namespace Collections;

class StackTest extends \PHPUnit_Framework_TestCase
{
    public function testForEach()
    {
        $array = array("one", "two", "three");
        $stack = new Stack($array);

        $ctr = 0;

        foreach ($stack as $key => $value) {
            $this->assertEquals($ctr, $key);
            $this->assertEquals($array[$ctr], $value);
            $ctr++;
        }
    }

    public function testPushPeekPop()
    {
        $stack = new Stack();
        $stack->push("one");
        $stack->push("two");

        $this->assertEquals(array("one", "two"), Enumerable::toArray($stack));

        $this->assertEquals("two", $stack->peek());

        $this->assertEquals("two", $stack->pop());

        $this->assertEquals(array("one"), Enumerable::toArray($stack));
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
