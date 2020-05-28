<?php

declare(strict_types=1);

namespace Aliless\Library;

use Aliless\Container;
use Aliyun\OTS\OTSClient;

class TableStore extends OTSClient
{
    public function __construct(Container $container)
    {
        $config = $container->config;
        $context = $container->context;
        $credentials = $context->credentials;

        parent::__construct([
            'EndPoint' => $config['tableStore']['endpoint'],
            'AccessKeyID' => $credentials->accessKeyId,
            'AccessKeySecret' => $credentials->accessKeySecret,
        ]);
    }
}
