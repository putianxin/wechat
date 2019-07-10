<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\OfficialAccount\Card;

use Ptx\Kernel\Exceptions\InvalidArgumentException;

/**
 * Class Card.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \Ptx\OfficialAccount\Card\CodeClient          $code
 * @property \Ptx\OfficialAccount\Card\MeetingTicketClient $meeting_ticket
 * @property \Ptx\OfficialAccount\Card\MemberCardClient    $member_card
 * @property \Ptx\OfficialAccount\Card\GeneralCardClient   $general_card
 * @property \Ptx\OfficialAccount\Card\MovieTicketClient   $movie_ticket
 * @property \Ptx\OfficialAccount\Card\CoinClient          $coin
 * @property \Ptx\OfficialAccount\Card\SubMerchantClient   $sub_merchant
 * @property \Ptx\OfficialAccount\Card\BoardingPassClient  $boarding_pass
 * @property \Ptx\OfficialAccount\Card\JssdkClient         $jssdk
 */
class Card extends Client
{
    /**
     * @param string $property
     *
     * @return mixed
     *
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     */
    public function __get($property)
    {
        if (isset($this->app["card.{$property}"])) {
            return $this->app["card.{$property}"];
        }

        throw new InvalidArgumentException(sprintf('No card service named "%s".', $property));
    }
}
