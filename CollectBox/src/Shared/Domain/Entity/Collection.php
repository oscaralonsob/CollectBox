<?php

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Exception\CollectionInvalidTypeException;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

//TODO: tests
class Collection implements Countable, IteratorAggregate
{
  protected array $elements = [];

  protected function __construct(array $elements)
  {
    $this->elements = $elements;
  }

  public static function empty(): self
  {
    return new self([]);
  }

  public static function create(array $elements): self
  {
    return new self($elements);
  }

  public function add(mixed $element): void
  {
    $this->elements[] = $element;
  }

  public function count(): int 
  {
    return count($this->elements);
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->elements);
  }

  public function toArray(): array
  {
    return $this->elements;
  }
}
