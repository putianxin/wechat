<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OfficialAccount\Base;

use Ptx\Kernel\ServiceContainer;
use Ptx\OfficialAccount\Base\Client;
use Ptx\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testClearQuota()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => '123456']));

        $client->expects()->httpPostJson('cgi-bin/clear_quota', [
            'appid' => '123456',
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->clearQuota());
    }

    public function testGetValidIps()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('cgi-bin/getcallbackip')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getValidIps());
    }
}
