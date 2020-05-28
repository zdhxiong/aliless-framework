<?php

declare(strict_types=1);

namespace Aliless\Library;

use Aliless\Container;
use AliyunFC\Client;

class FC extends Client
{
    public function __construct(Container $container)
    {
        $config = $container->config;
        $context = $container->context;
        $credentials = $context->credentials;

        parent::__construct([
            'accessKeyID' => $credentials->accessKeyId,
            'accessKeySecret' => $credentials->accessKeySecret,
            'endpoint' => $config['fc']['endpoint'],
            'securityToken' => $credentials->securityToken,
        ]);
    }
}
