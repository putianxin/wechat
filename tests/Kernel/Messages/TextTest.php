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

use Ptx\Kernel\Messages\Text;
use Ptx\Tests\TestCase;

class TextTest extends TestCase
{
    public function testBasicFeatures()
    {
        $text = new Text('mock-content');

        $this->assertSame('mock-content', $text->content);
    }
}
