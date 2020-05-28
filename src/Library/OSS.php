<?php

declare(strict_types=1);

namespace Aliless\Library;

use Aliless\Container;
use OSS\OSSClient;

class OSS extends OSSClient
{
    public function __construct(Container $container)
    {
        $config = $container->config;
        $context = $container->context;
        $credentials = $context->credentials;

        parent::__construct(
            $credentials->accessKeyId,
            $credentials->accessKeySecret,
            $config['oss']['endpoint'],
            false,
            $credentials->securityToken
        );
    }
}
