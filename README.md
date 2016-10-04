# Collections
[![Build Status](https://travis-ci.org/jjware/Collections.svg?branch=master)](https://travis-ci.org/jjware/Collections)

A library of collection types in PHP

## Getting Started
```
composer require jjware/collections
```

## Usage
Collections can be instantiated from existing arrays or without any arguments. A simple example of using a collection would be:
```php
use Collections\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);

$firstOverThree = $collection->where(function ($item) {
  return $item > 3;
})->firstOrDefault(null);

// $firstOverThree === 4
```
Collections implement the `IteratorAggregate`, `ArrayAccess`, `Countable`, `Serializable`, and `JsonSerializable` interfaces.

There are also specialized collection classes for functionality such as queuing:
```php
use Collections\Queue;

$queue = new Queue([1, 2, 3, 4, 5]);

$next = $queue->dequeue();

// $next === 1
```
Or for stacking:
```php
use Collections\Stack;

$stack = new Stack([1, 2, 3, 4, 5]);

$next = $stack->pop();

// $next === 5
```
The `Collections\EnumerableExtensions` trait can be used on any `Traversable` to give it a lot of collection-like functionality.
```php
EnumerableExtensions::all(callable $predicate): Enumerable
EnumerableExtensions::any(callable $predicate): Enumerable
EnumerableExtensions::contains(mixed $object): bool
EnumerableExtensions::count(): int
EnumerableExtensions::countWhere(callable $predicate): int
EnumerableExtensions::distinct(): Enumerable
EnumerableExtensions::distinctWhere(EqualityComparerInterface $comparer): Enumerable
EnumerableExtensions::each(callable $callback): void
EnumerableExtensions::elementAt(int $index): mixed
EnumerableExtensions::elementAtOrDefault(int $index, mixed $default): mixed
EnumerableExtensions::except(array $ignore): Enumerable
EnumerableExtensions::exceptWhere(array $ignore, EqualityComparerInterface $comparer): Enumerable
EnumerableExtensions::first(): mixed
EnumerableExtensions::firstOrDefault(mixed $default): mixed
EnumerableExtensions::last(): mixed
EnumerableExtensions::lastOrDefault(mixed $default): mixed
EnumerableExtensions::ofType(string $type): mixed
EnumerableExtensions::skip(int $number): Enumerable
EnumerableExtensions::toArray(): array
EnumerableExtensions::where(callable $predicate): Enumerable
```

Full documentation to come in the future...
