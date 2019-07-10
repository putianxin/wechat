<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OfficialAccount\ShakeAround;

use Ptx\Kernel\Exceptions\InvalidArgumentException;
use Ptx\OfficialAccount\Application;
use Ptx\OfficialAccount\ShakeAround\Client;
use Ptx\OfficialAccount\ShakeAround\DeviceClient;
use Ptx\OfficialAccount\ShakeAround\GroupClient;
use Ptx\OfficialAccount\ShakeAround\MaterialClient;
use Ptx\OfficialAccount\ShakeAround\RelationClient;
use Ptx\OfficialAccount\ShakeAround\ShakeAround;
use Ptx\OfficialAccount\ShakeAround\StatsClient;
use Ptx\Tests\TestCase;

class ShakeAroundTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application();
        $shakeAround = new ShakeAround($app);

        $this->assertInstanceOf(Client::class, $shakeAround);
        $this->assertInstanceOf(DeviceClient::class, $shakeAround->device);
        $this->assertInstanceOf(GroupClient::class, $shakeAround->group);
        $this->assertInstanceOf(MaterialClient::class, $shakeAround->material);
        $this->assertInstanceOf(RelationClient::class, $shakeAround->relation);
        $this->assertInstanceOf(StatsClient::class, $shakeAround->stats);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No shake_around service named "foo".', $shakeAround->foo);
    }
}
