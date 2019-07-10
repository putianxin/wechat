<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx;

/**
 * Class Factory.
 *
 * @method static \Ptx\Payment\Application            payment(array $config)
 * @method static \Ptx\MiniProgram\Application        miniProgram(array $config)
 * @method static \Ptx\OpenPlatform\Application       openPlatform(array $config)
 * @method static \Ptx\OfficialAccount\Application    officialAccount(array $config)
 * @method static \Ptx\BasicService\Application       basicService(array $config)
 * @method static \Ptx\Work\Application               work(array $config)
 * @method static \Ptx\OpenWork\Application           openWork(array $config)
 * @method static \Ptx\MicroMerchant\Application      microMerchant(array $config)
 */
class Factory
{
    /**
     * @param string $name
     * @param array  $config
     *
     * @return \Ptx\Kernel\ServiceContainer
     */
    public static function make($name, array $config)
    {
        $namespace = Kernel\Support\Str::studly($name);
        $application = "\\Ptx\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
