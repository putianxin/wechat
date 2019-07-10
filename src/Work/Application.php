<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Work;

use Ptx\Kernel\ServiceContainer;
use Ptx\Work\MiniProgram\Application as MiniProgram;

/**
 * Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \Ptx\Work\OA\Client                   $oa
 * @property \Ptx\Work\Auth\AccessToken            $access_token
 * @property \Ptx\Work\Agent\Client                $agent
 * @property \Ptx\Work\Department\Client           $department
 * @property \Ptx\Work\Media\Client                $media
 * @property \Ptx\Work\Menu\Client                 $menu
 * @property \Ptx\Work\Message\Client              $message
 * @property \Ptx\Work\Message\Messenger           $messenger
 * @property \Ptx\Work\User\Client                 $user
 * @property \Ptx\Work\User\TagClient              $tag
 * @property \Ptx\Work\Server\ServiceProvider      $server
 * @property \Ptx\BasicService\Jssdk\Client        $jssdk
 * @property \Overtrue\Socialite\Providers\WeWorkProvider $oauth
 * @property \Ptx\Work\Invoice\Client              $invoice
 * @property \Ptx\Work\Chat\Client                 $chat
 * @property \Ptx\Work\ExternalContact\Client      $external_contact
 * @property \Ptx\Work\ExternalContact\ContactWayClient      $contact_way
 * @property \Ptx\Work\ExternalContact\StatisticsClient      $external_contact_statistics
 * @property \Ptx\Work\ExternalContact\MessageClient      $external_contact_message
 *
 * @method mixed getCallbackIp()
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        OA\ServiceProvider::class,
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Menu\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        User\ServiceProvider::class,
        Agent\ServiceProvider::class,
        Media\ServiceProvider::class,
        Message\ServiceProvider::class,
        Department\ServiceProvider::class,
        Server\ServiceProvider::class,
        Jssdk\ServiceProvider::class,
        Invoice\ServiceProvider::class,
        Chat\ServiceProvider::class,
        ExternalContact\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        // http://docs.guzzlephp.org/en/stable/request-options.html
        'http' => [
            'base_uri' => 'https://qyapi.weixin.qq.com/',
        ],
    ];

    /**
     * Creates the miniProgram application.
     *
     * @return \Ptx\Work\MiniProgram\Application
     */
    public function miniProgram(): MiniProgram
    {
        return new MiniProgram($this->getConfig());
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this['base']->$method(...$arguments);
    }
}
