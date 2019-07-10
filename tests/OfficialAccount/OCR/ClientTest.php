<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OfficialAccount\OCR;

use Ptx\Kernel\Exceptions\InvalidArgumentException;
use Ptx\OfficialAccount\OCR\Client;
use Ptx\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testIdCard()
    {
        $client = $this->mockApiClient(Client::class);

        $path = '/foo/bar.jpg';
        $client->expects()->httpGet('cv/ocr/idcard', [
            'type' => 'photo',
            'img_url' => $path,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->idCard($path, 'photo'));

        $client->expects()->httpGet('cv/ocr/idcard', [
            'type' => 'scan',
            'img_url' => $path,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->idCard($path, 'scan'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported type: \'image\'');
        $client->idCard($path, 'image');
    }

    public function testBankCard()
    {
        $client = $this->mockApiClient(Client::class);

        $path = '/foo/bar.jpg';
        $client->expects()->httpGet('cv/ocr/bankcard', [
            'img_url' => $path,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->bankCard($path));
    }

    public function testVehicleLicense()
    {
        $client = $this->mockApiClient(Client::class);

        $path = '/foo/bar.jpg';
        $client->expects()->httpGet('cv/ocr/driving', [
            'img_url' => $path,
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->vehicleLicense($path));
    }
}
