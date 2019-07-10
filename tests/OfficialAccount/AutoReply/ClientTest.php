<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OfficialAccount\AutoReply;

use Ptx\OfficialAccount\AutoReply\Client;
use Ptx\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testCurrent()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/get_current_autoreply_info')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->current());
    }
}
