<?php

namespace Plain\Contact;

/**
 * 
 * @package   Plain Contact
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/license
 */

use Closure;
use Kirby\Content\Content;
use Kirby\Content\Field;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Exception\LogicException;
use Kirby\Panel\Assets;
use Kirby\Toolkit\Collection;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\I18n;
use Kirby\Toolkit\Obj;
use SimpleXMLElement;

class Options extends Collection
{

    static private ?array $optionsCache = null; 
    private array $values = []; 

    public function __construct(null|array $data = [], bool $caseSensitive = false)
	{        
        //Get options from options
        $data ??= $this->getOptions();
        parent::__construct($data, $caseSensitive);
    }

    public static function factory($data): self
    {
        if ($data instanceof Field) {
            $data = static::optionsFromField($data);
        }
        return new static($data);
    }

    private static function optionsFromField(Field $field): array
    {
        $values = $field->yaml();
        
        //Get options from blueprints
        if (array_key_exists('options', $values[0] ?? [])) {
            return A::map($values, fn($value) => $value['options']);
        }
        
        $field_key = $field->key();
        $blueprint = $field->parent()->blueprint()->field($field_key);
        return $blueprint['options'] ?? 
        throw new LogicException("Cannot get options from blueprint in field '{$field_key}'. (use saveOptions: true)");

    }

    /**
     * Cache and return all options.
     * 
     * @return array 
     */
    public function getOptions():array
    {
        if (static::$optionsCache) {
            return static::$optionsCache;
        }

        return A::map(
            array_keys(option('plain.contact.types') ?? []),
            fn($key) => $this->getOption($key)
        );

    }

    /**
     * Cache and parse a single option (without data)
     * 
     * @param mixed $key 
     * @return array 
     * @throws InvalidArgumentException 
     */
    public function getOption($key): array
    {
        if ($option = static::$optionsCache[$key] ?? null) {
            return $option;
        }

        $data = option('plain.contact.types.'.$key) ?? [];

        return static::$optionsCache[$key] = $this->parseOption($key, $data);

    }


    public function __set(string|int $key, $value): void
	{

        if ($value === null) {
            return;
        }
        
        if ($value === true) {
            $this->data[$key] = $this->getOption($key);
            return;
        }

        if(is_numeric($key)) {
            $key = is_string($value) ? $value : $value['type'];
        }

        $data = $this->parseOption($key, $value);

        //Merge data with options and put to data
		$this->data[$key] = A::merge($this->getOption($key), $data);

	}

	public function get($key, $data = null)
	{
        $option = $this->__get($key) ?? null;
        return ($data) ? $this->resolveOutput($option, $data) : $option;
	}

	public function render(array $data = [], ?array $values = null)
	{
        return A::map($this->data, function($item) use ($data, $values) {
            $type = $item['type'];
            if ($values) {
                $values = A::merge(
                    A::find($values, fn($value) => $type === ($value['type'] ?? null)) ?? [],
                    $data
                );
            }
            return new Obj($this->get($type, $values ?? $data));
        });

	}

    public function resolveOutput($value, $data) {
        if ($value && $data && array_key_exists('output', $value)) {
            $value['svg'] = $this->getSvg($value['icon']);
            $parsed = A::map($value['output'], fn($ln) => Str::template($ln, $data));
            unset($value['output']);
            return A::merge($value, $parsed);
        }
        return $value;
    }

    private function translate($text) {

        if (is_array($text) === false) {
			$text = ['en' => $text];
		}

        return I18n::translate($text, $text);
    }

    public function getSvg($name): ?string
    {
        $assets = new Assets();
        $file   = $assets->icons();
        $svg    = new SimpleXMLElement($file);

        foreach ($svg->defs->children() as $symbol) {
            if ((string)$symbol->attributes()->id === 'icon-' . $name) {
                $svg = $symbol->asXML();
                $svg = str_replace('<symbol', '<svg', $svg);
                return str_replace('</symbol>', '</svg>', $svg);
            }
        }

        return null;
    }

    private function parseOption(string $key, array|string $option):array
    {

        if (is_string($option)) {
            $option = ['label' => $option];
        }

        $text = $option['label'] ?? $option['text'] ?? Str::ucfirst($key);

        return A::merge($option, [
            'validate' => A::wrap($option['validate'] ?? []),
            'label' => $this->translate($text),
            'type' => $key
        ]);

    }

    public function toArray(Closure $map = null): array
    {
        return array_values($this->data);
    }


}
