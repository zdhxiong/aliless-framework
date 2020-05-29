<?php

declare(strict_types=1);

namespace Aliless\Context;

/**
 * 当前 service 的基本信息
 */
class Service
{
    /**
     * service 名称
     *
     * @var string
     */
    public $name;

    /**
     * 接入的日志服务的 logProject
     *
     * @var string
     */
    public $logProject;

    /**
     * 接入的日志服务的 logStore
     *
     * @var string
     */
    public $logStore;

    /**
     * 当前调用的 service 版本或别名
     *
     * @var string
     */
    public $qualifier;

    /**
     * 当前实际调用的 service 的版本
     *
     * @var string
     */
    public $versionId;

    /**
     * initializer 函数名称
     *
     * @var string
     */
    public $initializer;

    /**
     * initializer 函数的超时时间
     *
     * @var int
     */
    public $initializationTimeout;

    public function __construct(array $service)
    {
        $keys = [
            'name',
            'logProject',
            'logStore',
            'qualifier',
            'versionId',
            'initializer',
            'initializationTimeout',
        ];

        foreach ($keys as $key) {
            if (isset($service[$key])) {
                $this->{$key} = $service[$key];
            }
        }
    }
}
