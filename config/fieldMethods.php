<?php

use Kirby\Toolkit\A;
use Plain\Contact\Options;

    return [
        'toContact' => function($field = null, string $snippet = 'contact', array $placeholder = []) {
            $options = Options::factory($field)->render($placeholder, $field->yaml());
            $contacts = A::filter($options, fn($opt) => $opt->contact() ?? false);
            return snippet(
                'contact/' . $snippet, compact('field', 'options', 'contacts'));
        }
    ];

?>