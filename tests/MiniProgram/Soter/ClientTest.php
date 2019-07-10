<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\MiniProgram\Soter;

use Ptx\MiniProgram\Soter\Client;
use Ptx\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testVerifySignature()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpPostJson('cgi-bin/soter/verify_signature', [
            'openid' => 'mock-openid',
            'json_string' => 'mock-json',
            'json_signature' => 'mock-signature',
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->verifySignature('mock-openid', 'mock-json', 'mock-signature'));
    }
}
