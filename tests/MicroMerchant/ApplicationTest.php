<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\MicroMerchant;

use Ptx\Kernel\Exceptions\InvalidArgumentException;
use Ptx\MicroMerchant\Application;
use Ptx\MicroMerchant\Kernel\Exceptions\InvalidSignException;
use Ptx\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application([
            'mch_id' => 'foo-merchant-id',
        ]);
        $this->assertInstanceOf(\Ptx\MicroMerchant\Certficates\Client::class, $app->certficates);
        $this->assertInstanceOf(\Ptx\MicroMerchant\Base\Client::class, $app->base);
        $this->assertInstanceOf(\Ptx\MicroMerchant\Material\Client::class, $app->material);
        $this->assertInstanceOf(\Ptx\MicroMerchant\MerchantConfig\Client::class, $app->merchantConfig);
        $this->assertInstanceOf(\Ptx\MicroMerchant\Withdraw\Client::class, $app->withdraw);
    }

    public function testGetKey()
    {
        $app = new Application(['key' => '88888888888888888888888888888888']);
        $this->assertSame('88888888888888888888888888888888', $app->getKey());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("'%s' should be 32 chars length.", '1234'));
        $app = new Application(['key' => '1234']);
        $app->getKey();
    }

    public function testSetSubMchId()
    {
        $app = new Application(['key' => '88888888888888888888888888888888']);
        $this->assertSame($app, $app->setSubMchId('sub_mch_id', 'appid'));
        $this->assertSame('sub_mch_id', $app->config->sub_mch_id);
        $this->assertSame('appid', $app->config->appid);
    }

    public function testVerifySignature()
    {
        $app = new Application(['key' => '88888888888888888888888888888888']);

        $this->assertSame(true, $app->verifySignature([
            'foo' => 'bar',
            'sign' => '834A25C9A5B48305AB997C9A7E101530',
        ]));

        $this->assertSame(false, $app->verifySignature([
            'foo' => 'bar',
        ]));
        $this->expectException(InvalidSignException::class);
        $this->expectExceptionMessage('return value signature verification error');
        $this->assertSame(true, $app->verifySignature([
            'foo' => 'bar',
            'sign' => '834A25C9A5B48305AB997C9A7E101531',
        ]));
    }
}
