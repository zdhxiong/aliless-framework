<?php

declare(strict_types=1);

namespace Aliless\Library;

use Aliless\Container;
use AliyunMNS\Client;

class MNS extends Client
{
    public function __construct(Container $container)
    {
        $config = $container->config;
        $context = $container->context;
        $credentials = $context->credentials;

        parent::__construct(
            $config['mns']['endpoint'],
            $credentials->accessKeyId,
            $credentials->accessKeyId,
            $credentials->securityToken
        );
    }
}
