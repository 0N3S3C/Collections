<?php

namespace Collections;

class LengthEqualityComparer implements EqualityComparerInterface
{
    public function equals($x, $y)
    {
        return strlen($x) === strlen($y);
    }
}

class EnumerableTest extends \PHPUnit_Framework_TestCase
{
    public function testAllWhenSame()
    {
        $enumerable = new Enumerable(['one', 'one', 'one']);

        $result = $enumerable->all(function ($test) {
            return $test == 'one';
        });

        $this->assertTrue($result);
    }

    public function testAllWhenNotSame()
    {
        $enumerable = new Enumerable(['one', 'two', 'one']);

        $result = $enumerable->all(function ($test) {
            return $test == 'one';
        });

        $this->assertFalse($result);
    }

    public function testAnyWhenEmpty()
    {
        $enumerable = new Enumerable([]);

        $result = $enumerable->any(function ($x) {
            return $x === 'one';
        });

        $this->assertFalse($result);
    }

    public function testAnyWhenExists()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->any(function ($x) {
            return $x === 'two';
        });

        $this->assertTrue($result);
    }

    public function testAnyWhenNotExists()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->any(function ($x) {
            return $x === 'four';
        });

        $this->assertFalse($result);
    }

    public function testContainsWhenExists()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $this->assertTrue($enumerable->contains('two'));
    }

    public function testContainsWhenNotExists()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $this->assertFalse($enumerable->contains('four'));
    }

    public function testCount()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $this->assertEquals(3, $enumerable->count());
    }

    public function testCountWhere()
    {
        $enumerable = new Enumerable(['one', 'two', 'two', 'three']);

        $result = $enumerable->countWhere(function ($x) {
            return $x == 'two';
        });

        $this->assertEquals(2, $result);
    }

    public function testDistinct()
    {
        $enumerable = new Enumerable(['one', 'two', 'two', 'three']);

        $result = $enumerable->distinct()->toArray();

        $this->assertEquals(["one", "two", "three"], $result);
    }

    public function testDistinctWhere()
    {
        $enumerable = new Enumerable(['one', 'two', 'dos', 'three']);

        $result = $enumerable->distinctWhere(new LengthEqualityComparer())->toArray();

        $this->assertEquals(["one", "three"], $result);
    }

    public function testElementAtInRange()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->elementAt(1);

        $this->assertEquals('two', $result);
    }

    /**
     * @expectedException \Collections\IndexOutOfRangeException
     */
    public function testElementAtOutOfRange()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $enumerable->elementAt(3);
    }

    public function testElementAtOrDefaultInRange()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->elementAtOrDefault(1, null);

        $this->assertEquals('two', $result);
    }

    public function testElementAtOrDefaultOutOfRange()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->elementAtOrDefault(3, null);

        $this->assertEquals(null, $result);
    }

    public function testExcept()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->except(['one', 'three'])->toArray();

        $this->assertEquals(['two'], $result);
    }

    public function testExceptWhere()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->exceptWhere(['len'], new LengthEqualityComparer())->toArray();

        $this->assertEquals(['three'], $result);
    }

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testFirst()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals("one", Enumerable::first($object));

        $object->clear();
        Enumerable::first($object);
    }

    public function testFirstOrDefault()
    {
        $object = new MockEnumerable();

        $this->assertEquals(null, Enumerable::firstOrDefault($object, null));

        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals("one", Enumerable::firstOrDefault($object, null));
    }

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testLast()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals("three", Enumerable::last($object));

        $object->clear();
        Enumerable::last($object);
    }

    public function testLastOrDefault()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals("three", Enumerable::lastOrDefault($object, null));

        $object->clear();

        $this->assertEquals(null, Enumerable::lastOrDefault($object, null));
    }

    public function testOfType()
    {
        $object = new MockEnumerable();
        $object->add(new MockEnumerable());
        $object->add(new LengthEqualityComparer());
        $object->add(new \stdClass());
        $object->add(new MockEnumerable());

        $result = Enumerable::toArray(Enumerable::ofType($object, "Collections\\MockEnumerable"));

        $this->assertEquals([new MockEnumerable(), new MockEnumerable()], $result);
    }

    public function testToArray()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->toArray();

        $this->assertEquals(["one", "two", "three"], $result);
    }
}
