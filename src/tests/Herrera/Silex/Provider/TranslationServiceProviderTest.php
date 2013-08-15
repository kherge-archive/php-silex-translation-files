<?php

namespace Herrera\Silex\Provider\Tests;

use Herrera\PHPUnit\TestCase;
use Herrera\Silex\Provider\TranslationServiceProvider;
use Silex\Application;

class TranslationServiceProviderTest extends TestCase
{
    public function testRegister()
    {
        $file = $this->createFile();

        file_put_contents(
            $file,
            <<<YAML
test: The translation is successful.
YAML
        );

        $app = new Application();
        $app->register(
            new TranslationServiceProvider(),
            array(
                'translation.files' => array(
                    'Symfony\\Component\\Translation\\Loader\\YamlFileLoader' => array(
                        $file => 'en'
                    )
                )
            )
        );

        $this->assertEquals(
            'The translation is successful.',
            $app['translator']->trans('test')
        );
    }

    public function testRegisterMissingClass()
    {
        $app = new Application();
        $app->register(
            new TranslationServiceProvider(),
            array(
                'translation.files' => array(
                    'No\\Such\\Class' => array()
                )
            )
        );

        $this->setExpectedException(
            'InvalidArgumentException',
            'The loader class "No\\Such\\Class" does not exist.'
        );

        $app['translator'];
    }
}
