<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Test\OfficialAccount\Card;

use Ptx\OfficialAccount\Application;
use Ptx\OfficialAccount\Card\BoardingPassClient;
use Ptx\OfficialAccount\Card\Card;
use Ptx\OfficialAccount\Card\Client;
use Ptx\OfficialAccount\Card\CodeClient;
use Ptx\OfficialAccount\Card\CoinClient;
use Ptx\OfficialAccount\Card\GeneralCardClient;
use Ptx\OfficialAccount\Card\JssdkClient;
use Ptx\OfficialAccount\Card\MeetingTicketClient;
use Ptx\OfficialAccount\Card\MemberCardClient;
use Ptx\OfficialAccount\Card\MovieTicketClient;
use Ptx\OfficialAccount\Card\SubMerchantClient;
use Ptx\Tests\TestCase;

class CardTest extends TestCase
{
    public function testBasicProperties()
    {
        $app = new Application();
        $card = new Card($app);

        $this->assertInstanceOf(Client::class, $card);
        $this->assertInstanceOf(BoardingPassClient::class, $card->boarding_pass);
        $this->assertInstanceOf(MeetingTicketClient::class, $card->meeting_ticket);
        $this->assertInstanceOf(MovieTicketClient::class, $card->movie_ticket);
        $this->assertInstanceOf(CoinClient::class, $card->coin);
        $this->assertInstanceOf(MemberCardClient::class, $card->member_card);
        $this->assertInstanceOf(GeneralCardClient::class, $card->general_card);
        $this->assertInstanceOf(CodeClient::class, $card->code);
        $this->assertInstanceOf(SubMerchantClient::class, $card->sub_merchant);
        $this->assertInstanceOf(JssdkClient::class, $card->jssdk);

        try {
            $card->foo;
            $this->fail('No expected exception thrown.');
        } catch (\Exception $e) {
            $this->assertSame('No card service named "foo".', $e->getMessage());
        }
    }
}
