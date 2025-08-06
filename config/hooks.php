<?php 

use Plain\Contact\Option;

use Kirby\Toolkit\Str;
use Kirby\Toolkit\A;

return [
    'plain.contact.options:before' => function($options, $model, ?array $data = null) {

        $types = option('plain.contact.types') ?? [];

        $options ??= array_keys($types);

        $result = [];

        foreach ($options as $key => $option) {

            if(is_numeric($key)) {
                $key = is_string($option) ? $option : $option['value'];
            }

            $option = match(true) {
                $option === true => [],
                is_string($option) => ['value' => $option],
                is_array($option) => $option,
                default => []
            };
            
            $option = A::merge(
                $types[$key] ?? [],
                $option
            );

            $option['value'] ??= $key;
            $option['text'] ??= Str::ucfirst($key);

            if ($data && array_key_exists('links', $option)) {
                $option['links'] = A::map($option['links'], fn($ln) => Str::template($ln, $data));
            }

            $result[] = Option::factory($option)->render($model);
        }

        return $result;

    }
]
?>