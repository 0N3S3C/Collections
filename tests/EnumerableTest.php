<?php

namespace Collections;

class MockEnumerable implements EnumerableInterface
{
    private $objects = [];

    public function add($object)
    {
        $this->objects[] = $object;
    }

    public function clear()
    {
        $this->objects = [];
    }

    public function getIterator()
    {
        return new ArrayEnumerator($this->objects);
    }

    public function toArray()
    {
        return $this->objects;
    }
}

class LengthEqualityComparer implements EqualityComparerInterface
{
    public function equals($x, $y)
    {
        return strlen($x) === strlen($y);
    }
}

class EnumerableTest extends \PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("one");
        $object->add("one");

        $result = Enumerable::all($object, function ($test) {
            return $test == "one";
        });
        $this->assertTrue($result);

        $object->add("two");

        $result = Enumerable::all($object, function ($test) {
            return $test == "one";
        });
        $this->assertFalse($result);
    }

    public function testAny()
    {
        $object = new MockEnumerable();

        $this->assertFalse(Enumerable::any($object));

        $object->add("one");

        $this->assertTrue(Enumerable::any($object));

        $object->add("two");
        $object->add("three");

        $result = Enumerable::any($object, function ($x) {
            return $x == "two";
        });

        $this->assertTrue($result);

        $result = Enumerable::any($object, function ($x) {
            return $x == "four";
        });

        $this->assertFalse($result);
    }

    public function testContains()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertTrue(Enumerable::contains($object, "two"));
        $this->assertFalse(Enumerable::contains($object, "four"));
    }

    public function testCount()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals(3, Enumerable::count($object));
    }

    public function testCountWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::countWhere($object, function ($test) {
            return $test == "two";
        });

        $this->assertEquals(2, $result);
    }

    public function testDistinct()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::toArray(Enumerable::distinct($object));

        $this->assertEquals(["one", "two", "three"], $result);
    }

    public function testDistinctWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::toArray(Enumerable::distinctWhere($object, new LengthEqualityComparer()));

        $this->assertEquals(["one", "three"], $result);
    }

    /**
     * @expectedException \Collections\IndexOutOfRangeException
     */
    public function testElementAt()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals("two", Enumerable::elementAt($object, 1));
        Enumerable::elementAt($object, 5);
    }

    public function testElementAtOrDefault()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals("two", Enumerable::elementAtOrDefault($object, 1, null));
        $this->assertEquals(null, Enumerable::elementAtOrDefault($object, 5, null));
    }

    public function testExcept()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::toArray(Enumerable::except($object, ["one", "three"]));

        $this->assertEquals(["two"], $result);
    }

    public function testExceptWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::toArray(Enumerable::exceptWhere($object, ["nah"], new LengthEqualityComparer()));

        $this->assertEquals(["three"], $result);
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

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testFirstWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::firstWhere($object, function ($test) {
            return strlen($test) > 3;
        });

        $this->assertEquals("three", $result);

        Enumerable::firstWhere($object, function ($test) {
            return strlen($test) > 6;
        });
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

    public function testFirstOrDefaultWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $result = Enumerable::firstOrDefaultWhere($object, function ($test) {
            return strlen($test) > 3;
        }, null);

        $this->assertEquals("three", $result);

        $result = Enumerable::firstOrDefaultWhere($object, function ($test) {
            return strlen($test) > 6;
        }, null);

        $this->assertEquals(null, $result);
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

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testLastWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");
        $object->add("four");

        $result = Enumerable::lastWhere($object, function ($test) {
            return strlen($test) > 3;
        });

        $this->assertEquals("four", $result);

        Enumerable::lastWhere($object, function ($test) {
            return strlen($test) > 6;
        });
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

    public function testLastOrNullWhere()
    {
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");
        $object->add("four");

        $result = Enumerable::lastOrDefaultWhere($object, function ($test) {
            return strlen($test) > 3;
        }, null);

        $this->assertEquals("four", $result);

        $result = Enumerable::lastOrDefaultWhere($object, function ($test) {
            return strlen($test) > 6;
        }, null);

        $this->assertEquals(null, $result);
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
        $object = new MockEnumerable();
        $object->add("one");
        $object->add("two");
        $object->add("three");

        $this->assertEquals(["one", "two", "three"], $object->toArray());
    }
}
