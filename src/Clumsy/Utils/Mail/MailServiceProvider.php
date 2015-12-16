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
     * @param  array  $config
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function registerSwiftTransport($config)
    {
        switch ($config['driver'])
        {
            case 'mandrill-subaccount':
                return $this->registerMandrillWithSubaccountTransport($config);

            default:
                return parent::registerSwiftTransport($config);
        }
    }

    /**
     * Register the Mandrill with Subaccount Swift Transport instance.
     *
     * @param  array  $config
     * @return void
     */
    protected function registerMandrillWithSubaccountTransport($config)
    {
        $mandrill = $this->app['config']->get('services.mandrill', array());

        $this->app->bindShared('swift.transport', function() use ($mandrill)
        {
            return new MandrillTransport($mandrill['secret']);
        });
    }
}