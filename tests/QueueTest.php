<?php

namespace Collections;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    public function testEnqueuePeekDequeue()
    {
        $queue = new Queue();
        $queue->enqueue("one");
        $queue->enqueue("two");

        $this->assertEquals(array("one", "two"), Enumerable::toArray($queue));

        $this->assertEquals("one", $queue->peek());

        $this->assertEquals("one", $queue->dequeue());

        $this->assertEquals(array("two"), Enumerable::toArray($queue));
    }

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testDequeueUnderFlow()
    {
        $queue = new Queue();
        $queue->dequeue();
    }

    public function testForEach()
    {
        $array = array("one", "two", "three");
        $queue = new Queue($array);

        $ctr = 0;

        foreach ($queue as $key => $value) {
            $this->assertEquals($ctr, $key);
            $this->assertEquals($array[$ctr], $value);
            $ctr++;
        }
    }
}
