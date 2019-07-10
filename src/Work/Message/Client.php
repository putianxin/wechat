<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Work\Message;

use Ptx\Kernel\BaseClient;
use Ptx\Kernel\Messages\Message;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @param string|\Ptx\Kernel\Messages\Message $message
     *
     * @return \Ptx\Work\Message\Messenger
     *
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     */
    public function message($message)
    {
        return (new Messenger($this))->message($message);
    }

    /**
     * @param array $message
     *
     * @return \Psr\Http\Message\ResponseInterface|\Ptx\Kernel\Support\Collection|array|object|string
     */
    public function send(array $message)
    {
        return $this->httpPostJson('cgi-bin/message/send', $message);
    }
}
