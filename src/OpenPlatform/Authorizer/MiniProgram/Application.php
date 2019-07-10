<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\OpenPlatform\Authorizer\MiniProgram;

use Ptx\MiniProgram\Application as MiniProgram;
use Ptx\OpenPlatform\Authorizer\Aggregate\AggregateServiceProvider;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \Ptx\OpenPlatform\Authorizer\MiniProgram\Account\Client $account
 * @property \Ptx\OpenPlatform\Authorizer\MiniProgram\Code\Client    $code
 * @property \Ptx\OpenPlatform\Authorizer\MiniProgram\Domain\Client  $domain
 * @property \Ptx\OpenPlatform\Authorizer\MiniProgram\Setting\Client $setting
 * @property \Ptx\OpenPlatform\Authorizer\MiniProgram\Tester\Client  $tester
 */
class Application extends MiniProgram
{
    /**
     * Application constructor.
     *
     * @param array $config
     * @param array $prepends
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($config, $prepends);

        $providers = [
            AggregateServiceProvider::class,
            Code\ServiceProvider::class,
            Domain\ServiceProvider::class,
            Account\ServiceProvider::class,
            Setting\ServiceProvider::class,
            Tester\ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
