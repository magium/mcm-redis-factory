# MCM Redis Factory

This is a simple library that allows you to configure a Redis adapter using the [Magium Configuration Manager](https://github.com/magium/configuration-manager).

## Setup

Using it is really easy.

First install via composer

```
composer require magium/redis-factory
```

Then wire your application to use MCM.

```
$factory = new \Magium\Configuration\MagiumConfigurationFactory();
$config = $factory->getManager()->getConfiguration(getenv('ENVIRONMENT'));

$redis = \Magium\RedisFactory\Factory::factory($config);
```

## To Change Settings

Use the MCM configuration manager to change settings.  For example, if you are going to use the CLI to make changes you have the following options:

```
[kschroeder@dev ~]$ vendor/configuration-manager magium:configuration:list-keys
Valid configuration keys
magium/redis/host (default: localhost)
        (Hostname for the redis machine)

magium/redis/port (default: 6379)
        (Port for the server)

magium/redis/timeout (default: 2.5)
        (Connection timeout)

magium/redis/persistent (default: off)
        (Should the connection use a persistent connection?)

magium/redis/database
        (The default database number for the connection)
```

If you need to change the configuration to something else:

```
[kschroeder@dev ~]$ vendor/magium-configuration magium:configuration:set magium/redis/host hostname
```

Voila!  You're done.  No deployment necessary.
