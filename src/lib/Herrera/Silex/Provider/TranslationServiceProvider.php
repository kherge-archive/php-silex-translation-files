<?php

namespace Herrera\Silex\Provider;

use InvalidArgumentException;
use Silex\Application;
use Silex\Provider\TranslationServiceProvider as Provider;
use Symfony\Component\Translation\Translator;

/**
 * Supports the use of file sources for translations.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TranslationServiceProvider extends Provider
{
    /**
     * @override
     */
    public function register(Application $app)
    {
        parent::register($app);

        $app['translator'] = $app->share(
            $app->extend(
                'translator',
                function (Translator $translator, Application $app) {
                    if (isset($app['translation.files'])) {
                        $app['translator.files'] = $app['translation.files'];
                    }

                    if (isset($app['translator.files'])) {
                        foreach ($app['translator.files'] as $class => $files) {
                            $name = explode('\\', $class);
                            $name = array_pop($name);

                            if (!class_exists($class)) {
                                throw new InvalidArgumentException(
                                    sprintf(
                                        'The loader class "%s" does not exist.',
                                        $class
                                    )
                                );
                            }

                            $translator->addLoader($name, new $class());

                            foreach ($files as $file => $locale) {
                                $translator->addResource($name, $file, $locale);
                            }
                        }
                    }

                    return $translator;
                }
            )
        );
    }
}
