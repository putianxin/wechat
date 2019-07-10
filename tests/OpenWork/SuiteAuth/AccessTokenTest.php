<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OpenWork\SuiteAuth;

use Ptx\Kernel\ServiceContainer;
use Ptx\OpenWork\SuiteAuth\AccessToken;
use Ptx\OpenWork\SuiteAuth\SuiteTicket;
use Ptx\Tests\TestCase;

class AccessTokenTest extends TestCase
{
    public function testGetCredentials()
    {
        $suitTicket = \Mockery::mock(SuiteTicket::class, function ($mock) {
            $mock->expects()->getTicket()->andReturn('mock-suit-ticket');
        });

        $app = new ServiceContainer([
            'suite_id' => 'mock-suite-id',
            'suite_secret' => 'mock-suite-secret',
        ], ['suite_ticket' => $suitTicket]);

        $accessToken = \Mockery::mock(AccessToken::class, [$app])->makePartial()->shouldAllowMockingProtectedMethods();

        $this->assertSame([
            'suite_id' => 'mock-suite-id',
            'suite_secret' => 'mock-suite-secret',
            'suite_ticket' => 'mock-suit-ticket',
        ], $accessToken->getCredentials());
    }
}
