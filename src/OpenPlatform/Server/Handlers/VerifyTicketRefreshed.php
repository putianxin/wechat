<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\OpenPlatform\Server\Handlers;

use Ptx\Kernel\Contracts\EventHandlerInterface;
use Ptx\OpenPlatform\Application;

/**
 * Class VerifyTicketRefreshed.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class VerifyTicketRefreshed implements EventHandlerInterface
{
    /**
     * @var \Ptx\OpenPlatform\Application
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param \Ptx\OpenPlatform\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}.
     */
    public function handle($payload = null)
    {
        if (!empty($payload['ComponentVerifyTicket'])) {
            $this->app['verify_ticket']->setTicket($payload['ComponentVerifyTicket']);
        }
    }
}
