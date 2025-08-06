<?php

namespace Plain\Contact;

/**
 * Extend from src/Option/Option.php
 * 
 * @package   Plain Contact
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/license
 */

use Kirby\Option\Option as KirbyOption;

use Kirby\Blueprint\Factory;
use Kirby\Blueprint\NodeIcon;
use Kirby\Blueprint\NodeText;
use Kirby\Cms\ModelWithContent;

class Option extends KirbyOption
{
    public function __construct(
        public string|int|float|null $value,
        public bool $disabled = false,
        public NodeIcon|null $icon = null,
        public NodeText|null $text = null,
        public NodeText|null $color = null,
        public NodeArray|null $links = null,
        public NodeArray|null $validate = null,
    ) {
        $this->text ??= new NodeText(["en" => $this->value]);
    }

    public static function factory(string|int|float|null|array $props): static
    {
        if (is_array($props) === false) {
            $props = ["value" => $props];
        }
        
        $props = array_intersect_key($props, array_flip(['value', "icon", "text", "color", "links", 'validate']));

        $props = Factory::apply($props, [
            "icon"          => NodeIcon::class,
            "text"          => NodeText::class,
            "color"         => NodeText::class,
            "links"         => NodeArray::class,
            "validate"      => NodeArray::class
        ]);

        return new static(...$props);
    }

    /**
     * Renders all data for the option
     */
    public function render(ModelWithContent $model): array
    {
        return [
            "disabled" => $this->disabled,
            "value" => $this->value ?? "",
            "icon" => $this->icon?->render($model),
            "text" => $this->text?->render($model),
            "color" => $this->color?->render($model),
            "links" => $this->links?->render($model),
            "validate" => $this->validate?->render($model),
        ];
    }
}
