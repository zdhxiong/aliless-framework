<?php

declare(strict_types=1);

namespace Aliless\Context;

/**
 * 当前函数的基本信息
 */
class Func
{
    /**
     * 函数名
     *
     * @var string
     */
    public $name;

    /**
     * 函数入口
     *
     * @var string
     */
    public $handler;

    /**
     * 函数内存
     *
     * @var int
     */
    public $memory;

    /**
     * 超时时间
     *
     * @var int
     */
    public $timeout;

    public function __construct(array $function)
    {
        $this->name = $function['name'];
        $this->handler = $function['handler'];
        $this->memory = $function['memory'];
        $this->timeout = $function['timeout'];
    }
}
