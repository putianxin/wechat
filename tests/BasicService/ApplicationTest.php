<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\BasicService;

use Ptx\OfficialAccount\Application;
use Ptx\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application();

        $this->assertInstanceOf(\Ptx\BasicService\Media\Client::class, $app->media);
        $this->assertInstanceOf(\Ptx\BasicService\Url\Client::class, $app->url);
        $this->assertInstanceOf(\Ptx\BasicService\QrCode\Client::class, $app->qrcode);
        $this->assertInstanceOf(\Ptx\BasicService\Jssdk\Client::class, $app->jssdk);
    }
}
