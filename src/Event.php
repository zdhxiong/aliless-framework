<?php

declare(strict_types=1);

namespace Aliless;

/**
 * 来自 API 网关的 Event 对象
 */
class Event
{
    /**
     * 请求路径
     *
     * @var string
     */
    public $path;

    /**
     * HTTP 请求方法
     *
     * @var string
     */
    public $httpMethod;

    /**
     * header 参数
     *
     * @var array
     */
    public $headers;

    /**
     * query 参数
     *
     * @var array
     */
    public $queryParameters;

    /**
     * path 参数
     *
     * @var array
     */
    public $pathParameters;

    /**
     * 请求体
     *
     * @var mixed
     */
    public $body;

    /**
     * body 是否经过了 base64 编码。若经过了 base64 编码，则框架会自动进行解码
     *
     * @var bool
     */
    public $isBase64Encoded;

    public function __construct(string $event)
    {
        $event = json_decode($event, true);

        if ($event['isBase64Encoded']) {
            $event['body'] = base64_decode($event['body']);
        }

        if (
            isset($event['headers']['Content-Type']) &&
            strstr($event['headers']['Content-Type'], 'application/json')
        ) {
            $event['body'] = json_decode($event['body'], true);
        }

        $this->path = $event['path'];
        $this->httpMethod = $event['httpMethod'];
        $this->headers = $event['headers'];
        $this->queryParameters = $event['queryParameters'];
        $this->pathParameters = $event['pathParameters'];
        $this->body = $event['body'];
        $this->isBase64Encoded = $event['isBase64Encoded'];
    }
}
