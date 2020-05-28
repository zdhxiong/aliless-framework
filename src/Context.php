<?php

declare(strict_types=1);

namespace Aliless;

use Aliless\Context\Credentials;
use Aliless\Context\Func;
use Aliless\Context\Service;

/**
 * 函数运行时信息
 */
class Context
{
    /**
     * 本次调用请求的唯一 ID，常用于问题复查或历史调用计数
     *
     * @var string
     */
    public $requestId;

    /**
     * 函数计算服务通过扮演您提供的服务角色获得的一组临时密钥，每 15 分钟更新一次。
     * 您可以在代码中使用 credentials 去访问相应的服务（ 例如 OSS ），这就避免了您把自己的 AccessKey 信息写死在函数代码里。
     *
     * @var Credentials
     */
    public $credentials;

    /**
     * 当前调用的函数的一些基本信息，例如函数名、函数入口、函数内存和超时时间。
     *
     * @var Func
     */
    public $function;

    /**
     * 当前调用的函数所在的 service 的信息，包含 service 的名字、接入的日志服务的 logProject 和 logStore 信息、service 的版本信息、 qualifier 和 version_id。
     * 其中 qualifier 表示调用函数时指定的 service 版本或别名，version_id 表示实际调用的 service 版本。
     *
     * @var Service
     */
    public $service;

    /**
     * 当前调用的函数所在区域，例如 cn-shanghai。
     *
     * @var string
     */
    public $region;

    /**
     * 当前调用函数用户的阿里云 Account ID。
     *
     * @var string
     */
    public $accountId;

    public function __construct(array $context)
    {
        $this->requestId = $context['requestId'];
        $this->credentials = new Credentials($context['credentials']);
        $this->function = new Func($context['function']);
        $this->service = new Service($context['service']);
        $this->region = $context['region'];
        $this->accountId = $context['accountId'];
    }
}
