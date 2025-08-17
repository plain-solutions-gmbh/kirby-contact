<?php

/**
 * @package   Plain Contact
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/license
 */


@include_once __DIR__ . '/utils/load.php';

use Plain\Helpers\Plugin;

Plugin::load('plain/contact', autoloader: true);
