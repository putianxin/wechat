<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Work\MiniProgram;

use Ptx\MiniProgram\Application as MiniProgram;
use Ptx\Work\Auth\AccessToken;
use Ptx\Work\MiniProgram\Auth\Client;

/**
 * Class Application.
 *
 * @author Caikeal <caikeal@qq.com>
 *
 * @property \Ptx\Work\MiniProgram\Auth\Client $auth
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
        parent::__construct($config, $prepends + [
            'access_token' => function ($app) {
                return new AccessToken($app);
            },
            'auth' => function ($app) {
                return new Client($app);
            },
        ]);
    }
}
