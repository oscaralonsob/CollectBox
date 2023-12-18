<?php

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Exception\CollectionInvalidTypeException;

abstract class TypedCollection extends Collection
{
  abstract protected function type(): string;

  protected function __construct(array $elements)
  {
    $this->assertAllIsInstanceOf($elements);

    parent::__construct($elements);
  }

  public static function create(array $elements): Collection
  {
    return new static($elements);
  }

  public function add(mixed $element): void
  {
    $this->assertIsInstanceOf($element);

    parent::add($element);
  }

  private function assertIsInstanceOf(mixed $element): void
  {
    if (get_class($element) != $this->type()) {
      throw CollectionInvalidTypeException::create($this->type(), get_class($element));
    }
  }

  private function assertAllIsInstanceOf(array $elements): void
  {
    foreach ($elements as $element) {
      $this->assertIsInstanceOf($element);
    }
  }
}
