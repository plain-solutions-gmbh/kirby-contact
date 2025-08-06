<?php

namespace Plain\Contact;

use Kirby\Blueprint\NodeProperty;
use Kirby\Cms\ModelWithContent;
use Kirby\Toolkit\A;

class NodeArray extends NodeProperty
{
	public function __construct(
		public array $array,
	) {
	}

	public static function factory($value = null): static|null
	{
		return new static(A::wrap($value));
	}

	public function render(ModelWithContent $model): null|array
	{
		return $this->array;
	}
}
