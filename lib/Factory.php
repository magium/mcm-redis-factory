<?php

namespace Magium\RedisFactory;

use Magium\Configuration\Config\Repository\ConfigInterface;
use Magium\Configuration\Config\Repository\ConfigurationRepository;

class Factory
{

    const CONFIG_PERSISTENT = 'database/redis/persistent';
    const CONFIG_HOST = 'database/redis/host';
    const CONFIG_PORT = 'database/redis/port';
    const CONFIG_TIMEOUT = 'database/redis/timeout';
    const CONFIG_DATABASE = 'database/redis/database';

    private $config;
    protected static $me;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        self::$me = $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Creates a configured \Redis instance in the object context
     *
     * @param ConfigInterface $config
     * @return \Redis
     */

    public function factory()
    {
        $redis = new \Redis();
        $host = $this->getConfig()->getValue(self::CONFIG_HOST);
        $port = $this->getConfig()->getValue(self::CONFIG_PORT);
        $timeout = $this->getConfig()->getValue(self::CONFIG_TIMEOUT);

        if ($this->getConfig()->getValueFlag(self::CONFIG_PERSISTENT)) {
            $redis->pconnect($host, $port, $timeout);
        } else {
            $redis->connect($host, $port, $timeout);
        }

        if ($this->getConfig()->hasValue(self::CONFIG_DATABASE)) {
            $redis->select($this->getConfig()->getValue(self::CONFIG_DATABASE));
        }

        return $redis;
    }

    /**
     * Creates a configured \Redis instance in the static context
     *
     * @param ConfigInterface $config
     * @return \Redis
     */

    public static function staticFactory(ConfigInterface $config)
    {
        if (!self::$me instanceof self) {
            new self($config);
        }
        return self::$me->factory();
    }

}
