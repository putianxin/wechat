<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Tests\Kernel;

use Ptx\Kernel\BaseClient;
use Ptx\Kernel\Config;
use Ptx\Kernel\Log\LogManager;
use Ptx\Kernel\ServiceContainer;
use Ptx\Tests\TestCase;
use EasyWeChatComposer\Delegation\DelegationTo;
use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ServiceContainerTest extends TestCase
{
    public function testBasicFeatures()
    {
        $container = new ServiceContainer();

        $this->assertNotEmpty($container->getProviders());

        // __set, __get, offsetGet
        $this->assertInstanceOf(Config::class, $container['config']);
        $this->assertInstanceOf(Config::class, $container->config);

        $this->assertInstanceOf(Client::class, $container['http_client']);
        $this->assertInstanceOf(Request::class, $container['request']);
        $this->assertInstanceOf(LogManager::class, $container['log']);
        $this->assertInstanceOf(LogManager::class, $container['logger']);

        $container['foo'] = 'foo';
        $container->bar = 'bar';

        $this->assertSame('foo', $container['foo']);
        $this->assertSame('bar', $container['bar']);
    }

    public function testGetId()
    {
        $this->assertSame((new ServiceContainer(['app_id' => 'app-id1']))->getId(), (new ServiceContainer(['app_id' => 'app-id1']))->getId());
        $this->assertNotSame((new ServiceContainer(['app_id' => 'app-id1']))->getId(), (new ServiceContainer(['app_id' => 'app-id2']))->getId());
    }

    public function testRegisterProviders()
    {
        $container = new DummyContainerForProviderTest();

        $this->assertSame('foo', $container['foo']);
    }

    public function testMagicGetDelegation()
    {
        $container = \Mockery::mock(ServiceContainer::class);

        $container->shouldReceive('delegateTo')->andReturn(DelegationTo::class);
        $container->shouldReceive('offsetGet')->andReturn(BaseClient::class);
        $container->shouldReceive('shouldDelegate')->andReturn(true, false);

        $this->assertSame(DelegationTo::class, $container->log);
        $this->assertSame(BaseClient::class, $container->config);
    }
}

class DummyContainerForProviderTest extends ServiceContainer
{
    protected $providers = [
        FooServiceProvider::class,
    ];
}

class FooServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['foo'] = function () {
            return 'foo';
        };
    }
}
