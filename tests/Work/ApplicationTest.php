<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\Work;

use Ptx\Tests\TestCase;
use Ptx\Work\Application;
use Ptx\Work\Base\Client;

class ApplicationTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application([
            'corp_id' => 'xwnaka223',
            'agent_id' => 102093,
            'secret' => 'secret',
        ]);

        $this->assertInstanceOf(\Ptx\Work\OA\Client::class, $app->oa);
        $this->assertInstanceOf(\Ptx\Work\Auth\AccessToken::class, $app->access_token);
        $this->assertInstanceOf(\Ptx\Work\Agent\Client::class, $app->agent);
        $this->assertInstanceOf(\Ptx\Work\Chat\Client::class, $app->chat);
        $this->assertInstanceOf(\Ptx\Work\Department\Client::class, $app->department);
        $this->assertInstanceOf(\Ptx\Work\Media\Client::class, $app->media);
        $this->assertInstanceOf(\Ptx\Work\Menu\Client::class, $app->menu);
        $this->assertInstanceOf(\Ptx\Work\Message\Client::class, $app->message);
        $this->assertInstanceOf(\Ptx\Work\Message\Messenger::class, $app->messenger);
        $this->assertInstanceOf(\Ptx\Work\Server\Guard::class, $app->server);
        $this->assertInstanceOf(\Ptx\BasicService\Jssdk\Client::class, $app->jssdk);
        $this->assertInstanceOf(\Overtrue\Socialite\Providers\WeWorkProvider::class, $app->oauth);
        $this->assertInstanceOf(\Ptx\Work\ExternalContact\Client::class, $app->external_contact);
        $this->assertInstanceOf(\Ptx\Work\ExternalContact\ContactWayClient::class, $app->contact_way);
        $this->assertInstanceOf(\Ptx\Work\ExternalContact\StatisticsClient::class, $app->external_contact_statistics);
        $this->assertInstanceOf(\Ptx\Work\ExternalContact\MessageClient::class, $app->external_contact_message);
    }

    public function testMiniProgram()
    {
        $app = new Application([
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'permission' => 0777,
                'file' => '/tmp/easywechat.log',
            ],
            'debug' => true,
            'corp_id' => 'corp-id',
            'agent_id' => 100020,
            'secret' => 'secret',
        ]);

        $miniProgram = $app->miniProgram();
        $this->assertInstanceOf(\Ptx\Work\MiniProgram\Application::class, $miniProgram);
        $this->assertInstanceOf(\Ptx\Work\Auth\AccessToken::class, $miniProgram['access_token']);
        $this->assertInstanceOf(\Ptx\Work\MiniProgram\Auth\Client::class, $miniProgram['auth']);
        $this->assertArraySubset([
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'permission' => 0777,
                'file' => '/tmp/easywechat.log',
            ],
            'debug' => true,
            'corp_id' => 'corp-id',
            'agent_id' => 100020,
            'secret' => 'secret',
        ], $miniProgram->config->toArray());
    }

    public function testBaseCall()
    {
        $client = \Mockery::mock(Client::class);
        $client->expects()->getCallbackIp(1, 2, 3)->andReturn('mock-result');

        $app = new Application([]);
        $app['base'] = $client;

        $this->assertSame('mock-result', $app->getCallbackIp(1, 2, 3));
    }
}
