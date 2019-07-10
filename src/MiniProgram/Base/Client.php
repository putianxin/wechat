<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\MiniProgram\Base;

use Ptx\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get paid unionid.
     *
     * @return \Psr\Http\Message\ResponseInterface|\Ptx\Kernel\Support\Collection|array|object|string
     */
    public function getPaidUnionid($openid, $options = [])
    {
        return $this->httpGet('wxa/getpaidunionid', compact('openid') + $options);
    }
}
