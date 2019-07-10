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
use Ptx\OfficialAccount\ShakeAround\MaterialClient;
use Ptx\Tests\TestCase;

class MaterialClientTest extends TestCase
{
    public function testUploadImage()
    {
        $client = $this->mockApiClient(MaterialClient::class);

        $path = STUBS_ROOT.'/files/image.png';

        $client->expects()->httpUpload('shakearound/material/add', ['media' => $path], [], ['type' => 'icon'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->uploadImage($path));

        $client->expects()->httpUpload('shakearound/material/add', ['media' => $path], [], ['type' => 'cover'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->uploadImage($path, 'cover'));

        // invalid path
        $path = '/not/exists/path/to/image.jpg';
        $this->expectExceptionMessage(sprintf('File does not exist, or the file is unreadable: "%s"', $path));
        $this->expectException(InvalidArgumentException::class);
        $client->uploadImage($path);
    }
}
