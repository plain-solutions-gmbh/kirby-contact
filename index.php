<?php

/**
 * @package   Plain Contact
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/license
 */


use Kirby\Cms\App;
use Kirby\Data\Data;
use Kirby\Filesystem\F;

F::loadClasses([
    'Plain\Contact\NodeArray' => __DIR__ . '/classes/NodeArray.php',
    'Plain\Contact\Option' => __DIR__ . '/classes/Option.php',
    'Plain\Contact\Options' => __DIR__ . '/classes/Options.php',
]);

App::plugin('plain/contact', [
    'fieldMethods' => require __DIR__ . '/config/fieldMethods.php',
    'fields' => require __DIR__ . '/config/fields.php',
    'hooks' => require __DIR__ . '/config/hooks.php',
    'options' => require __DIR__ . '/config/options.php',
    'pageMethods' => require __DIR__ . '/config/pageMethods.php',
    'siteMethods' => require __DIR__ . '/config/siteMethods.php',
    'translations' => [
        'en' => Data::read(__DIR__ . '/I18n/en.json'),
    ],
    'snippets' => [
        'contact/contact' => __DIR__ . '/snippets/contact/contact.php',
        'contact/share' => __DIR__ . '/snippets/contact/share.php',
    ],
]);
