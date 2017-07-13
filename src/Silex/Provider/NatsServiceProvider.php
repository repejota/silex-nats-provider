<?php
namespace Silex\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Nats\Connection;

/**
 * Class NatsServiceProvider
 *
 * @package Silex\Provider
 */
class NatsServiceProvider implements ServiceProviderInterface
{
    /**
     * Default options
     */
    const DEFAULT_OPTIONS = [
        'server' => 'nats://localhost:4222',
    ];

    /**
     * Register Nats provider.
     *
     * @param Container $app Application dependency container.
     * @return void
     */
    public function register(Container $app)
    {
        $app['nats'] = function ($app) {
            // default options
            $config = NatsServiceProvider::DEFAULT_OPTIONS;

            // process options
            if (!isset($app['nats.config'])) {
                $app['nats.config'] = [];
            }
            foreach ($config as $key => $value) {
                if (isset($app['nats.config'][$key])) {
                    $config[$key] = $app['nats.config'][$key];
                }
            }
            $app['nats.config'] = $config;

            // create Nats connection
            $client = new Connection();
            return $client;
        };
    }
}