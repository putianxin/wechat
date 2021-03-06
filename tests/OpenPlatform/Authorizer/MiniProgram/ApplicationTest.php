<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OpenPlatform\Authorizer\MiniProgram;

use Ptx\OpenPlatform\Authorizer\MiniProgram\Application;
use Ptx\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application(['app_id' => 'app-id']);

        $this->assertInstanceOf(\Ptx\OpenPlatform\Authorizer\MiniProgram\Account\Client::class, $app->account);
    }
}
