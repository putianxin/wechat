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

use Ptx\Kernel\Exceptions\InvalidArgumentException;

/**
 * Class Card.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \Ptx\OfficialAccount\ShakeAround\DeviceClient   $device
 * @property \Ptx\OfficialAccount\ShakeAround\GroupClient    $group
 * @property \Ptx\OfficialAccount\ShakeAround\MaterialClient $material
 * @property \Ptx\OfficialAccount\ShakeAround\RelationClient $relation
 * @property \Ptx\OfficialAccount\ShakeAround\StatsClient    $stats
 */
class ShakeAround extends Client
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
        if (isset($this->app["shake_around.{$property}"])) {
            return $this->app["shake_around.{$property}"];
        }

        throw new InvalidArgumentException(sprintf('No shake_around service named "%s".', $property));
    }
}
