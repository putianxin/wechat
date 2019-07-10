<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\OpenWork;

use Ptx\OpenWork\Application;
use Ptx\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application(['corp_id' => 'mock-corp-id']);

        $this->assertInstanceOf(\Ptx\OpenWork\Server\Guard::class, $app->server);
        $this->assertInstanceOf(\Ptx\OpenWork\Corp\Client::class, $app->corp);
        $this->assertInstanceOf(\Ptx\OpenWork\Provider\Client::class, $app->provider);
    }

    public function testWork()
    {
        $app = new Application(['corp_id' => 'mock-corp-id']);
        $work = $app->work('mock-auth-corp-id', 'mock-permanent-code');

        $this->assertInstanceOf('\Ptx\OpenWork\Work\Application', $work);
        $this->assertInstanceOf('Ptx\OpenWork\Work\Auth\AccessToken', $work->access_token);

        $this->assertInstanceOf('Ptx\Work\Application', $work);
        $this->assertInstanceOf(\Ptx\Work\OA\Client::class, $work->oa);
        $this->assertInstanceOf(\Ptx\Work\Agent\Client::class, $work->agent);
        $this->assertInstanceOf(\Ptx\Work\Chat\Client::class, $work->chat);
        $this->assertInstanceOf(\Ptx\Work\Department\Client::class, $work->department);
        $this->assertInstanceOf(\Ptx\Work\Media\Client::class, $work->media);
        $this->assertInstanceOf(\Ptx\Work\Menu\Client::class, $work->menu);
        $this->assertInstanceOf(\Ptx\Work\Message\Client::class, $work->message);
        $this->assertInstanceOf(\Ptx\Work\Message\Messenger::class, $work->messenger);
        $this->assertInstanceOf(\Ptx\Work\Server\Guard::class, $work->server);
        $this->assertInstanceOf(\Ptx\BasicService\Jssdk\Client::class, $work->jssdk);
        $this->assertInstanceOf(\Overtrue\Socialite\Providers\WeWorkProvider::class, $work->oauth);
    }

    public function testDynamicCalls()
    {
        $app = new Application(['corp_id' => 'mock-corp-id']);
        $app['base'] = new class() {
            public function dummyMethod()
            {
                return 'mock-result';
            }
        };

        $this->assertSame('mock-result', $app->dummyMethod());
    }
}
