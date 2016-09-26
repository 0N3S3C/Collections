<?php

namespace Collections;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $collection = new Collection();

        $collection->add('one');

        $this->assertEquals(new Collection(['one']), $collection);

        $collection->add('two');

        $this->assertEquals(new Collection(['one', 'two']), $collection);

        $collection->add('three');

        $this->assertEquals(new Collection(['one', 'two', 'three']), $collection);
    }

    public function testClear()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->clear();

        $this->assertEquals(new Collection([]), $collection);
    }

    public function testCopyToDefaultBehavior()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $array = [];

        $collection->copyTo($array);

        $this->assertEquals(['one', 'two', 'three'], $array);
    }

    public function testCopyToWithIndexInMiddle()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $array = ['testing', 'testing', 'now', 'done'];

        $collection->copyTo($array, 2);

        $this->assertEquals(['testing', 'testing', 'one', 'two', 'three'], $array);
    }

    public function testCopyToWithIndexAtEnd()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $array = ['testing', 'testing'];

        $collection->copyTo($array, count($array));

        $this->assertEquals(['testing', 'testing', 'one', 'two', 'three'], $array);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testCopyToIndexLessThanZero()
    {
        $array = ['one', 'two', 'three'];

        $collection = new Collection();

        $collection->copyTo($array, -1);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testCopyToIndexNan()
    {
        $array = ['one', 'two', 'three'];

        $collection = new Collection();

        $collection->copyTo($array, 'j');
    }

    public function testExists()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $result = $collection->exists(function ($object) {
            return strlen($object) > 3;
        });

        $this->assertTrue($result);
    }

    public function testExistsWhenNot()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $result = $collection->exists(function ($object) {
            return $object === 'four';
        });

        $this->assertFalse($result);
    }

    public function testFind()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $result = $collection->find(function ($object) {
            return $object > 4;
        });

        $this->assertEquals(5, $result);
    }

    public function testFindWhenNot()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $result = $collection->find(function ($object) {
            return $object === "3";
        });

        $this->assertEquals(null, $result);
    }

    public function testFindAll()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $result = $collection->findAll(function ($object) {
            return $object > 3;
        });

        $this->assertEquals(new Collection([4, 5, 6]), $result);
    }

    public function testFindAllWhenNot()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $result = $collection->findAll(function ($object) {
            return $object > 7;
        });

        $this->assertEquals(new Collection([]), $result);
    }

    public function testGetItem()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals($collection[1], 2);
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testGetItemOutOfBounds()
    {
        $collection = new Collection();

        $collection[0];
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testGetItemInvalidArgument()
    {
        $collection = new Collection();

        $collection['j'];
    }

    public function testSetItem()
    {
        $collection = new Collection([1, 2, 3]);

        $collection[0] = 4;

        $this->assertEquals(new Collection([4, 2, 3]), $collection);
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testSetItemOutOfBounds()
    {
        $collection = new Collection();
        
        $collection[0] = 2;
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testSetItemInvalidArgument()
    {
        $collection = new Collection([1, 2, 3]);

        $collection['j'] = 2;
    }

    public function testRemove()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->remove('two');

        $this->assertEquals(new Collection(['one', 'three']), $collection);
    }

    public function testRemoveWhenNot()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->remove('four');

        $this->assertEquals(new Collection(['one', 'two', 'three']), $collection);
    }

    public function testRemoveAt()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->removeAt(1);

        $this->assertEquals(new Collection(['one', 'three']), $collection);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testRemoveAtInvalidArgument()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $collection->removeAt('j');
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testRemoveAtOutOfRange()
    {
        $collection = new Collection();

        $collection->removeAt(1);
    }

    public function testRemoveAll()
    {
        $collection = new Collection([3, 1, 2, 3, 4, 3, 5, 3]);

        $collection->removeAll(function ($object) {
            return $object === 3;
        });

        $this->assertEquals(new Collection([1, 2, 4, 5]), $collection);
    }

    public function testRemoveRange()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);
        $collection->removeRange(0, 4);

        $this->assertEquals([5, 6], $collection->toArray());

        $collection = new Collection([1, 2, 3, 4, 5, 6]);
        $collection->removeRange(3, 3);

        $this->assertEquals([1, 2, 3], $collection->toArray());

        $collection = new Collection([1, 2, 3, 4, 5, 6]);
        $collection->removeRange(2, 2);

        $this->assertEquals([1, 2, 5, 6], $collection->toArray());
    }

    public function testInsert()
    {
        $collection = new Collection();
        $collection->add("one");
        $collection->add("two");

        $collection->insert(1, "three");

        $this->assertEquals(["one", "three", "two"], $collection->toArray());
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testInsertInvalidArgument()
    {
        $collection = new Collection();
        $collection->insert('j', "one");
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testInsertOutOfRange()
    {
        $collection = new Collection();
        $collection->insert(4, "one");
    }

    public function testInsertPlusOne()
    {
        $collection = new Collection();
        $collection->add("one");

        $collection->insert(1, "two");

        $this->assertEquals(["one", "two"], $collection->toArray());
    }

    public function testIndexOf()
    {
        $collection = new Collection();
        $collection->add("one");
        $collection->add("two");
        $collection->add("three");

        $this->assertEquals(1, $collection->indexOf("two"));
        $this->assertEquals(-1, $collection->indexOf("four"));
    }

    public function testSortNumeric()
    {
        $collection = new Collection();
        $collection->add(2);
        $collection->add(5);
        $collection->add(3);
        $collection->add(1);
        $collection->add(4);

        $collection->sort();

        $this->assertEquals([1, 2, 3, 4, 5], $collection->toArray());
    }

    public function testSortAlphaNumeric()
    {
        $collection = new Collection();
        $collection->add("img12.png");
        $collection->add("img2.png");
        $collection->add("img10.png");
        $collection->add("img1.png");

        $collection->sort();

        $this->assertEquals(["img1.png", "img10.png", "img12.png", "img2.png"], $collection->toArray());
    }

    public function testSortWithNatural()
    {
        $collection = new Collection();
        $collection->add("img12.png");
        $collection->add("img2.png");
        $collection->add("img10.png");
        $collection->add("img1.png");
        $collection->sort(new NaturalStringComparer());

        $this->assertEquals(["img1.png", "img2.png", "img10.png", "img12.png"], $collection->toArray());
    }
}
