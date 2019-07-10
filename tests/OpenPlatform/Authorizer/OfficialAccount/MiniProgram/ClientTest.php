<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OpenPlatform\Authorizer\OfficialAccount\MiniProgram;

use Ptx\Kernel\ServiceContainer;
use Ptx\OpenPlatform\Authorizer\OfficialAccount\MiniProgram\Client;
use Ptx\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testList()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('cgi-bin/wxopen/wxamplinkget')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list());
    }

    public function testLink()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('cgi-bin/wxopen/wxamplink', [
            'appid' => 'wxa',
            'notify_users' => false,
            'show_profile' => true,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->link('wxa', false, true));
    }

    public function testUnlink()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('cgi-bin/wxopen/wxampunlink', [
            'appid' => 'wxa',
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->unlink('wxa'));
    }
}
