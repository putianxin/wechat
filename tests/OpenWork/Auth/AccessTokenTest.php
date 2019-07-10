<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OpenWork\Auth;

use Ptx\Kernel\ServiceContainer;
use Ptx\OpenWork\Auth\AccessToken;
use Ptx\Tests\TestCase;

class AccessTokenTest extends TestCase
{
    public function testGetCredentials()
    {
        $app = new ServiceContainer([
            'corp_id' => 'mock-corp-id',
            'secret' => 'mock-secret',
        ]);

        $accessToken = \Mockery::mock(AccessToken::class, [$app])->makePartial()->shouldAllowMockingProtectedMethods();

        $this->assertSame([
            'corpid' => 'mock-corp-id',
            'provider_secret' => 'mock-secret',
        ], $accessToken->getCredentials());
    }
}
