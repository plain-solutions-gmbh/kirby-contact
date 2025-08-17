<?php

use Kirby\Toolkit\A;
use Plain\Contact\Options;

    return [
        'toShare' => function(array|string|null $options = null, string $snippet = 'share', array $placeholder = []) {
            $page = $this;
            $placeholder['url'] ??= urlencode($this->url());
            $options = Options::factory($options)->render($placeholder);
            $shares = A::filter($options, fn($opt) => $opt->share() ?? false);
            return snippet('contact/'.$snippet, compact('page', 'options', 'shares'));
        }
    ];

?>