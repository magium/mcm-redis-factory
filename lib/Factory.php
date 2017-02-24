<?php

namespace Magium\RedisFactory;

use Magium\Configuration\Config\ConfigurationRepository;

class Factory
{

    const CONFIG_PERSISTENT = 'database/redis/persistent';
    const CONFIG_HOST = 'database/redis/host';
    const CONFIG_PORT = 'database/redis/port';
    const CONFIG_TIMEOUT = 'database/redis/timeout';
    const CONFIG_DATABASE = 'database/redis/database';

    /**
     * Creates a configured \Redis instance
     *
     * @param ConfigurationRepository $config
     * @return \Redis
     */

    public static function factory(ConfigurationRepository $config)
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
