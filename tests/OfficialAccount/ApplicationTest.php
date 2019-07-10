<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OfficialAccount;

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
        $this->assertInstanceOf(\Ptx\OfficialAccount\Auth\AccessToken::class, $app->access_token);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Server\Guard::class, $app->server);
        $this->assertInstanceOf(\Ptx\OfficialAccount\User\UserClient::class, $app->user);
        $this->assertInstanceOf(\Ptx\OfficialAccount\User\TagClient::class, $app->user_tag);
        $this->assertInstanceOf(\Overtrue\Socialite\Providers\WeChatProvider::class, $app->oauth);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Menu\Client::class, $app->menu);
        $this->assertInstanceOf(\Ptx\OfficialAccount\TemplateMessage\Client::class, $app->template_message);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Material\Client::class, $app->material);
        $this->assertInstanceOf(\Ptx\OfficialAccount\CustomerService\Client::class, $app->customer_service);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Semantic\Client::class, $app->semantic);
        $this->assertInstanceOf(\Ptx\OfficialAccount\DataCube\Client::class, $app->data_cube);
        $this->assertInstanceOf(\Ptx\OfficialAccount\AutoReply\Client::class, $app->auto_reply);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Broadcasting\Client::class, $app->broadcasting);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Card\Client::class, $app->card);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Device\Client::class, $app->device);
        $this->assertInstanceOf(\Ptx\OfficialAccount\ShakeAround\Client::class, $app->shake_around);
        $this->assertInstanceOf(\Ptx\OfficialAccount\Base\Client::class, $app->base);
    }
}
