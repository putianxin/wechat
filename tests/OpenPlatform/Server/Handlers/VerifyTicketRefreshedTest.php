<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OpenPlatform;

use Ptx\OpenPlatform\Application;
use Ptx\OpenPlatform\Auth\VerifyTicket;
use Ptx\OpenPlatform\Server\Handlers\VerifyTicketRefreshed;
use Ptx\Tests\TestCase;

class VerifyTicketRefreshedTest extends TestCase
{
    public function testHandle()
    {
        $app = new Application();
        $app['verify_ticket'] = \Mockery::mock(VerifyTicket::class, function ($mock) {
            $mock->expects()->setTicket('ticket');
        });
        $handler = new VerifyTicketRefreshed($app);

        $this->assertNull($handler->handle([
            'ComponentVerifyTicket' => 'ticket',
        ]));
    }
}
