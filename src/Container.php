<?php

declare(strict_types=1);

namespace Aliless;

use Aliless\Library\FC;
use Aliless\Library\Logger;
use Aliless\Library\MNS;
use Aliless\Library\OSS;
use Aliless\Library\TableStore;
use Aliless\Library\View;
use AliyunFC\Client as FCClient;
use Psr\Log\LoggerInterface;
use AliyunMNS\Client as MNSClient;
use OSS\OSSClient;
use Aliyun\OTS\OTSClient;

/**
 * @property-read FCClient        $fc
 * @property-read LoggerInterface $logger
 * @property-read MNSClient       $mns
 * @property-read OSSClient       $oss
 * @property-read OTSClient       $tableStore
 * @property-read View            $view
 * @property-read Event           $event
 * @property-read Context         $context
 * @property-read array           $config
 */
class Container extends \Pimple\Container
{
    /**
     * 默认容器键名和实例类名
     *
     * @var string[]
     */
    protected $dependencies = [
        'fc' => FC::class,
        'logger' => Logger::class,
        'mns' => MNS::class,
        'oss' => OSS::class,
        'tableStore' => TableStore::class,
        'view' => View::class,
    ];

    /**
     * 其他依赖
     *
     * @var string[]
     */
    protected $customDependencies = [];

    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        $dependencies = $this->getDependencies();
        $dependencies['config'] = include __DIR__ . '/../../../../config.php';

        parent::__construct(array_merge($dependencies, $values));
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * 获取默认容器依赖项
     *
     * @return array
     */
    protected function getDependencies()
    {
        $dependencies = array_merge($this->dependencies, $this->customDependencies);

        return array_map(function($class) {
            return function(Container $container) use ($class) {
                return new $class($container);
            };
        }, $dependencies);
    }
}
