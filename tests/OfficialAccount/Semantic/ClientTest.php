<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OfficialAccount\Semantic;

use Ptx\Kernel\ServiceContainer;
use Ptx\OfficialAccount\Semantic\Client;
use Ptx\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testQuery()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => '123456']));

        $client->expects()->httpPostJson('semantic/semproxy/search', [
            'query' => 'keywords',
            'category' => 'foo,bar',
            'appid' => '123456',
            'name' => 'easywechat',
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->query('keywords', 'foo,bar', ['name' => 'easywechat']));
    }
}
