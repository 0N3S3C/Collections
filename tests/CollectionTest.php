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

    public function testRemoveRangeAtBeginning()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $collection->removeRange(0, 4);

        $this->assertEquals(new Collection([5, 6]), $collection);
    }

    public function testRemoveRangeAtMiddle()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $collection->removeRange(3, 3);

        $this->assertEquals(new Collection([1, 2, 3]), $collection);
    }

    public function testRemoveRangeAtEnd()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $collection->removeRange(4, 2);

        $this->assertEquals(new Collection([1, 2, 3, 4]), $collection);
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testRemoveRangeOverflow()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->removeRange(2, 3);
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testRemoveRangeInvalidIndex()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->removeRange(3, 1);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testRemoveRangeInvalidTypeIndex()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->removeRange('j', 1);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testRemoveRangeInvalidTypeCount()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->removeRange(1, 'j');
    }

    public function testInsert()
    {
        $collection = new Collection(['one', 'two']);

        $collection->insert(1, 'three');

        $this->assertEquals(new Collection(['one', 'three', 'two']), $collection);
    }

    /**
     * @expectedException \Collections\InvalidArgumentException
     */
    public function testInsertInvalidArgument()
    {
        $collection = new Collection();

        $collection->insert('j', 'one');
    }

    public function testInsertAtNextIndex()
    {
        $collection = new Collection(['one']);

        $collection->insert(1, 'two');

        $this->assertEquals(new Collection(['one', 'two']), $collection);
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testInsertAtNextIndexPlusOne()
    {
        $collection = new Collection(['one']);

        $collection->insert(2, 'two');
    }

    /**
     * @expectedException \Collections\ArgumentOutOfRangeException
     */
    public function testInsertAtNegativeIndex()
    {
        $collection = new Collection(['one']);

        $collection->insert(-1, 'two');
    }

    public function testIndexOfWhereExists()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $result = $collection->indexOf('two');

        $this->assertEquals(1, $result);
    }

    public function testIndexOfWhereExistMultiple()
    {
        $collection = new Collection(['one', 'two', 'one', 'three']);

        $result = $collection->indexOf('one');

        $this->assertEquals(0, $result);
    }

    public function testIndexOfWhereNotExists()
    {
        $collection = new Collection(['one', 'two', 'three']);

        $result = $collection->indexOf('four');

        $this->assertEquals(-1, $result);
    }

    public function testSortNumeric()
    {
        $collection = new Collection([2, 5, 3, 1, 4]);

        $collection->sort();

        $this->assertEquals(new Collection([1, 2, 3, 4, 5]), $collection);
    }

    public function testSortAlphaNumeric()
    {
        $collection = new Collection(['img12.png', 'img2.png', 'img10.png', 'img1.png']);

        $collection->sort();

        $this->assertEquals(new Collection(['img1.png', 'img10.png', 'img12.png', 'img2.png']), $collection);
    }

    public function testSortWithNatural()
    {
        $collection = new Collection(['img12.png', 'img2.png', 'img10.png', 'img1.png']);

        $collection->sort(new NaturalStringComparer());

        $this->assertEquals(new Collection(['img1.png', 'img2.png', 'img10.png', 'img12.png']), $collection);
    }
}
