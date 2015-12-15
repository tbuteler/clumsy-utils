<?php

namespace Clumsy\Utils\Mail;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Mail\TransportManager;
use Illuminate\Mail\MailServiceProvider as BaseProvider;

class MailServiceProvider extends BaseProvider
{
    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerSwiftTransport()
    {
        $this->app['swift.transport'] = $this->app->share(function ($app) {

            $transport = new TransportManager($app);

            $transport->extend('mandrill-subaccount', function () {

                $client = new HttpClient;

                $config = $this->app['config']->get('services.mandrill', []);

                return new MandrillTransport($client, $config['secret']);
            });

            return $transport;
        });
    }
}