<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\OfficialAccount\ShakeAround;

use Ptx\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author overtrue <i@overtrue.me>
 */
class Client extends BaseClient
{
    /**
     * @param array $data
     *
     * @return array|\Ptx\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function register($data)
    {
        return $this->httpPostJson('shakearound/account/register', $data);
    }

    /**
     * Get audit status.
     *
     * @return \Psr\Http\Message\ResponseInterface|\Ptx\Kernel\Support\Collection|array|object|string
     */
    public function status()
    {
        return $this->httpGet('shakearound/account/auditstatus');
    }

    /**
     * Get shake info.
     *
     * @param string $ticket
     * @param bool   $needPoi
     *
     * @return \Psr\Http\Message\ResponseInterface|\Ptx\Kernel\Support\Collection|array|object|string
     */
    public function user(string $ticket, bool $needPoi = false)
    {
        $params = [
            'ticket' => $ticket,
        ];

        if ($needPoi) {
            $params['need_poi'] = 1;
        }

        return $this->httpPostJson('shakearound/user/getshakeinfo', $params);
    }

    /**
     * @param string $ticket
     *
     * @return array|\Ptx\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function userWithPoi(string $ticket)
    {
        return $this->user($ticket, true);
    }
}
