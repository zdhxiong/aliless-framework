<?php

declare(strict_types=1);

namespace Aliless\Context;

/**
 * 临时密钥
 */
class Credentials
{
    /**
     * @var string
     */
    public $accessKeyId;

    /**
     * @var string
     */
    public $accessKeySecret;

    /**
     * @var string
     */
    public $securityToken;

    public function __construct(array $credentials)
    {
        $this->accessKeyId = $credentials['accessKeyId'];
        $this->accessKeySecret = $credentials['accessKeySecret'];
        $this->securityToken = $credentials['securityToken'];
    }
}
