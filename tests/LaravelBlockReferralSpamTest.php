<?php

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class LaravelBlockReferralSpamTest extends Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.referral_spam_list_location', dirname(__FILE__) . '/../vendor/piwik/referrer-spam-blacklist/spammers.txt');

        $app['router']->get('hello', function () {
            return 'hello world';
        });

        $app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('DougSisk\BlockReferralSpam\Middleware\BlockReferralSpam');
    }

    public function testValidRequest()
    {
        $this->call('GET', 'hello', [], [], [], [
            'HTTP_REFERER' => "http://www.google.com"
        ]);

        $this->assertResponseOk();
    }

    public function testInvalidRequest()
    {
        $this->call('GET', 'hello', [], [], [], [
            'HTTP_REFERER' => "http://www.allknow.info"
        ]);

        $this->assertResponseStatus(401);
    }

    public function testInvalidSubdomainRequest()
    {
        $this->call('GET', 'hello', [], [], [], [
            'HTTP_REFERER' => "http://с.новым.годом.рф"
        ]);

        $this->assertResponseStatus(401);
    }
}
