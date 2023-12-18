<?php

namespace App\Shared\Domain\Entity;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class Collection implements Countable, IteratorAggregate
{
  protected function __construct(protected array $elements)
  {
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
