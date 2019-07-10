<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Test\Kernel\Messages;

use Ptx\Kernel\Messages\Card;
use Ptx\Tests\TestCase;

class CardTest extends TestCase
{
    public function testBasicFeatures()
    {
        $card = new Card('mock-card-id');

        $this->assertSame('mock-card-id', $card->card_id);
    }
}
