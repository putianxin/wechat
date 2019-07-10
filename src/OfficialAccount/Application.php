<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\OfficialAccount;

use Ptx\BasicService;
use Ptx\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \Ptx\BasicService\Media\Client                     $media
 * @property \Ptx\BasicService\Url\Client                       $url
 * @property \Ptx\BasicService\QrCode\Client                    $qrcode
 * @property \Ptx\BasicService\Jssdk\Client                     $jssdk
 * @property \Ptx\OfficialAccount\Auth\AccessToken              $access_token
 * @property \Ptx\OfficialAccount\Server\Guard                  $server
 * @property \Ptx\OfficialAccount\User\UserClient               $user
 * @property \Ptx\OfficialAccount\User\TagClient                $user_tag
 * @property \Ptx\OfficialAccount\Menu\Client                   $menu
 * @property \Ptx\OfficialAccount\TemplateMessage\Client        $template_message
 * @property \Ptx\OfficialAccount\Material\Client               $material
 * @property \Ptx\OfficialAccount\CustomerService\Client        $customer_service
 * @property \Ptx\OfficialAccount\CustomerService\SessionClient $customer_service_session
 * @property \Ptx\OfficialAccount\Semantic\Client               $semantic
 * @property \Ptx\OfficialAccount\DataCube\Client               $data_cube
 * @property \Ptx\OfficialAccount\AutoReply\Client              $auto_reply
 * @property \Ptx\OfficialAccount\Broadcasting\Client           $broadcasting
 * @property \Ptx\OfficialAccount\Card\Card                     $card
 * @property \Ptx\OfficialAccount\Device\Client                 $device
 * @property \Ptx\OfficialAccount\ShakeAround\ShakeAround       $shake_around
 * @property \Ptx\OfficialAccount\POI\Client                    $poi
 * @property \Ptx\OfficialAccount\Store\Client                  $store
 * @property \Ptx\OfficialAccount\Base\Client                   $base
 * @property \Ptx\OfficialAccount\Comment\Client                $comment
 * @property \Ptx\OfficialAccount\OCR\Client                    $ocr
 * @property \Overtrue\Socialite\Providers\WeChatProvider              $oauth
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Server\ServiceProvider::class,
        User\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        Menu\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        Material\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        Semantic\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        POI\ServiceProvider::class,
        AutoReply\ServiceProvider::class,
        Broadcasting\ServiceProvider::class,
        Card\ServiceProvider::class,
        Device\ServiceProvider::class,
        ShakeAround\ServiceProvider::class,
        Store\ServiceProvider::class,
        Comment\ServiceProvider::class,
        Base\ServiceProvider::class,
        OCR\ServiceProvider::class,
        // Base services
        BasicService\QrCode\ServiceProvider::class,
        BasicService\Media\ServiceProvider::class,
        BasicService\Url\ServiceProvider::class,
        BasicService\Jssdk\ServiceProvider::class,
    ];
}
