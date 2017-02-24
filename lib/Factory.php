<?php

namespace Magium\RedisFactory;

use Magium\Configuration\Config\ConfigurationRepository;

class Factory
{

    const CONFIG_PERSISTENT = 'magium/redis/persistent';
    const CONFIG_HOST = 'magium/redis/host';
    const CONFIG_PORT = 'magium/redis/port';
    const CONFIG_TIMEOUT = 'magium/redis/timeout';
    const CONFIG_DATABASE = 'magium/redis/database';

    public function factory(ConfigurationRepository $config)
    {
        $redis = new \Redis();
        $host = $config->getValue(self::CONFIG_HOST);
        $port = $config->getValue(self::CONFIG_PORT);
        $timeout = $config->getValue(self::CONFIG_TIMEOUT);

        if ($config->getValueFlag(self::CONFIG_PERSISTENT)) {
            $redis->pconnect($host, $port, $timeout);
        } else {
            $redis->connect($host, $port, $timeout);
        }

        if ($config->hasValue(self::CONFIG_DATABASE)) {
            $redis->select($config->getValue(self::CONFIG_DATABASE));
        }

        return $redis;
    }

}
