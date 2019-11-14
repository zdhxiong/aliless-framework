<?php

declare(strict_types=1);

namespace Aliless;

use Aliless\Dependencies\Logger;
use Aliless\Dependencies\View;

/**
 * @property-read mixed                      $event
 * @property-read array                      $context
 * @property-read \Aliless\Dependencies\View $view
 * @property-read \Psr\Log\LoggerInterface   $logger
 */
class Container extends \Pimple\Container
{
    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        $dependencies = $this->getDependencies();

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
        $dependencies = [
            'view' => View::class,
            'logger' => Logger::class,
        ];

        return array_map(function($class) {
            return function(Container $container) use ($class) {
                return new $class($container);
            };
        }, $dependencies);
    }
}
