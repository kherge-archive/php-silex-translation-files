Translation Files
=================

[![Build Status][]](https://travis-ci.org/herrera-io/php-silex-translation-files)

This is a [Silex][] service provider that extends the existing Translation
service in order to more easily support the use of translation files. You
can specify the loader, the files, and the locales all as a parameter.

Example
-------

```php
use Herrera\Silex\Provider\TranslationServiceProvider;
use Silex\Application;

$app = new Application();

$app->register(
    new TranslationServiceProvider(),
    array(
        'translation.files' => array(
            'Symfony\\Component\\Translation\\Loader\\YamlFileLoader' => array(
                '/path/to/file.de.yml' => 'de',
                '/path/to/file.en.yml' => 'en',
                '/path/to/file.fr.yml' => 'fr'
            )
        )
    )
);

$translated = $app['translator']->trans($key);
```

Installation
------------

Use Composer:

    $ composer.phar require "herrera-io/silex-translation-files=~1.0"

[Silex]: http://silex.sensiolabs.org/
[Build Status]: https://travis-ci.org/herrera-io/php-silex-translation-files.png
