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

        $result = $enumerable->distinct();

        $this->assertEquals(new Enumerable(['one', 'two', 'three']), $result);
    }

    public function testDistinctWhere()
    {
        $enumerable = new Enumerable(['one', 'two', 'dos', 'three']);

        $result = $enumerable->distinctWhere(new LengthEqualityComparer());

        $this->assertEquals(new Enumerable(['one', 'three']), $result);
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

        $result = $enumerable->except(['one', 'three']);

        $this->assertEquals(new Enumerable(['two']), $result);
    }

    public function testExceptWhere()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->exceptWhere(['len'], new LengthEqualityComparer());

        $this->assertEquals(new Enumerable(['three']), $result);
    }

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testFirstWhenEmpty()
    {
        $enumerable = new Enumerable([]);

        $enumerable->first();
    }

    public function testFirstWhenPopulated()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->first();

        $this->assertEquals('one', $result);
    }

    public function testFirstOrDefaultWhenEmpty()
    {
        $enumerable = new Enumerable([]);

        $result = $enumerable->firstOrDefault('empty');

        $this->assertEquals('empty', $result);
    }

    public function testFirstOrDefaultWhenPopulated()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->firstOrDefault('empty');

        $this->assertEquals('one', $result);
    }

    /**
     * @expectedException \Collections\InvalidOperationException
     */
    public function testLastWhenEmpty()
    {
        $enumerable = new Enumerable([]);

        $enumerable->last();
    }

    public function testLastWhenPopulated()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->last();

        $this->assertEquals('three', $result);
    }

    public function testLastOrDefaultWhenEmpty()
    {
        $enumerable = new Enumerable([]);

        $result = $enumerable->lastOrDefault('empty');

        $this->assertEquals('empty', $result);
    }

    public function testLastOrDefaultWhenPopulated()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->lastOrDefault('empty');

        $this->assertEquals('three', $result);
    }

    public function testOfType()
    {
        $enumerable = new Enumerable([
            new \stdClass(),
            new Enumerable([]),
            new \stdClass(),
            new LengthEqualityComparer(),
            new \stdClass()
        ]);

        $result = $enumerable->ofType('stdClass');

        $this->assertEquals(new Enumerable([new \stdClass(), new \stdClass(), new \stdClass()]), $result);
    }

    public function testToArray()
    {
        $enumerable = new Enumerable(['one', 'two', 'three']);

        $result = $enumerable->toArray();

        $this->assertEquals(['one', 'two', 'three'], $result);
    }
}
