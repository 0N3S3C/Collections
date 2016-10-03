<?php

namespace Collections;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $dictionary = new Dictionary();

        $dictionary->add('one', 1);

        $this->assertEquals(new Dictionary(['one' => 1]), $dictionary);

        $dictionary->add('two', 2);

        $this->assertEquals(new Dictionary(['one' => 1, 'two' => 2]), $dictionary);

        $dictionary->add('three', 3);

        $this->assertEquals(new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]), $dictionary);
    }

    /**
     * @expectedException \OverflowException
     */
    public function testAddOverflowException()
    {
        $dictionary = new Dictionary(['one' => 1]);

        $dictionary->add('one', 2);
    }

    public function testClear()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $dictionary->clear();

        $this->assertEquals(new Dictionary([]), $dictionary);
    }

    public function testContainsWhenKeyExists()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->contains('two');

        $this->assertTrue($result);
    }

    public function testContainsWhenKeyDoesNotExist()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->contains('four');

        $this->assertFalse($result);
    }

    public function testContainsKeyWhenKeyExists()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->containsKey('two');

        $this->assertTrue($result);
    }

    public function testContainsKeyWhenKeyDoesNotExist()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->containsKey('four');

        $this->assertFalse($result);
    }

    public function testContainsValueWheValueExists()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->containsValue(2);

        $this->assertTrue($result);
    }

    public function testContainsValueWhenValueDoesNotExist()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->containsValue(4);

        $this->assertFalse($result);
    }

    public function testCopyToDefaultBehavior()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $array = [];

        $dictionary->copyTo($array);

        $expected = [
            new KeyValuePair('one', 1),
            new KeyValuePair('two', 2),
            new KeyValuePair('three', 3)
        ];

        $this->assertEquals($expected, $array);
    }

    public function testCopyToWithIndexInMiddle()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $array = ['testing', 'testing', 'now', 'done'];

        $dictionary->copyTo($array, 2);

        $expected = [
            'testing',
            'testing',
            new KeyValuePair('one', 1),
            new KeyValuePair('two', 2),
            new KeyValuePair('three', 3)
        ];

        $this->assertEquals($expected, $array);
    }

    public function testCopyToWithIndexAtEnd()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $array = ['testing', 'testing'];

        $dictionary->copyTo($array, count($array));

        $expected = [
            'testing',
            'testing',
            new KeyValuePair('one', 1),
            new KeyValuePair('two', 2),
            new KeyValuePair('three', 3)
        ];

        $this->assertEquals($expected, $array);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testCopyToIndexLessThanZero()
    {
        $array = ['one', 'two', 'three'];

        $dictionary = new Dictionary();

        $dictionary->copyTo($array, -1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCopyToIndexNan()
    {
        $array = ['one', 'two', 'three'];

        $dictionary = new Dictionary();

        $dictionary->copyTo($array, 'j');
    }

    public function testCount()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->count();

        $this->assertEquals(3, $result);
    }

    public function testGetKeys()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->getKeys();

        $this->assertEquals(new ReadOnlyCollection(new Collection(['one', 'two', 'three'])), $result);
    }

    public function testGetValues()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->getValues();

        $this->assertEquals(new ReadOnlyCollection(new Collection([1, 2, 3])), $result);
    }

    public function testRemoveWhenExists()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->remove('two');

        $this->assertTrue($result);

        $this->assertEquals(new Dictionary(['one' => 1, 'three' => 3]), $dictionary);
    }

    public function testRemoveWhenDoesNotExist()
    {
        $dictionary = new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]);

        $result = $dictionary->remove('four');

        $this->assertFalse($result);

        $this->assertEquals(new Dictionary(['one' => 1, 'two' => 2, 'three' => 3]), $dictionary);
    }
}
