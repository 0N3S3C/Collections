<?php

namespace Collections;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    public function testEnqueue()
    {
        $queue = new Queue();

        $queue->enqueue('one');

        $this->assertEquals(new Queue(['one']), $queue);

        $queue->enqueue('two');

        $this->assertEquals(new Queue(['one', 'two']), $queue);

        $queue->enqueue('three');

        $this->assertEquals(new Queue(['one', 'two', 'three']), $queue);
    }

    public function testPeek()
    {
        $queue = new Queue(['one', 'two', 'three']);

        $result = $queue->peek();

        $this->assertEquals('one', $result);

        // assert that the Queue is left unchanged
        $this->assertEquals(new Queue(['one', 'two', 'three']), $queue);
    }

    public function testDequeue()
    {
        $queue = new Queue(['one', 'two', 'three']);

        $result = $queue->dequeue();

        $this->assertEquals('one', $result);

        $this->assertEquals(new Queue(['two', 'three']), $queue);

        $result = $queue->dequeue();

        $this->assertEquals('two', $result);

        $this->assertEquals(new Queue(['three']), $queue);

        $result = $queue->dequeue();

        $this->assertEquals('three', $result);

        $this->assertEquals(new Queue([]), $queue);
    }

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testDequeueUnderFlow()
    {
        $queue = new Queue();

        $queue->dequeue();
    }

    public function testCopyToDefaultBehavior()
    {
        $queue = new Queue(['one', 'two', 'three']);

        $array = [];

        $queue->copyTo($array);

        $this->assertEquals(['one', 'two', 'three'], $array);
    }

    public function testCopyToWithIndexInMiddle()
    {
        $queue = new Queue(['one', 'two', 'three']);

        $array = ['testing', 'testing', 'now', 'done'];

        $queue->copyTo($array, 2);

        $this->assertEquals(['testing', 'testing', 'one', 'two', 'three'], $array);
    }

    public function testCopyToWithIndexAtEnd()
    {
        $queue = new Queue(['one', 'two', 'three']);

        $array = ['testing', 'testing'];

        $queue->copyTo($array, count($array));

        $this->assertEquals(['testing', 'testing', 'one', 'two', 'three'], $array);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testCopyToIndexLessThanZero()
    {
        $array = ['one', 'two', 'three'];

        $queue = new Queue();

        $queue->copyTo($array, -1);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testCopyToIndexNan()
    {
        $array = ['one', 'two', 'three'];

        $queue = new Queue();

        $queue->copyTo($array, 'j');
    }
}
