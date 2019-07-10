<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\MiniProgram;

use Ptx\BasicService;
use Ptx\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \Ptx\MiniProgram\Auth\AccessToken           $access_token
 * @property \Ptx\MiniProgram\DataCube\Client            $data_cube
 * @property \Ptx\MiniProgram\AppCode\Client             $app_code
 * @property \Ptx\MiniProgram\Auth\Client                $auth
 * @property \Ptx\OfficialAccount\Server\Guard           $server
 * @property \Ptx\MiniProgram\Encryptor                  $encryptor
 * @property \Ptx\MiniProgram\TemplateMessage\Client     $template_message
 * @property \Ptx\OfficialAccount\CustomerService\Client $customer_service
 * @property \Ptx\MiniProgram\Plugin\Client              $plugin
 * @property \Ptx\MiniProgram\UniformMessage\Client      $uniform_message
 * @property \Ptx\MiniProgram\ActivityMessage\Client     $activity_message
 * @property \Ptx\MiniProgram\Express\Client             $logistics
 * @property \Ptx\MiniProgram\NearbyPoi\Client           $nearby_poi
 * @property \Ptx\MiniProgram\OCR\Client                 $ocr
 * @property \Ptx\MiniProgram\Soter\Client               $soter
 * @property \Ptx\BasicService\Media\Client              $media
 * @property \Ptx\BasicService\ContentSecurity\Client    $content_security
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        UniformMessage\ServiceProvider::class,
        ActivityMessage\ServiceProvider::class,
        OpenData\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        Base\ServiceProvider::class,
        Express\ServiceProvider::class,
        NearbyPoi\ServiceProvider::class,
        OCR\ServiceProvider::class,
        Soter\ServiceProvider::class,
        // Base services
        BasicService\Media\ServiceProvider::class,
        BasicService\ContentSecurity\ServiceProvider::class,
    ];

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}
