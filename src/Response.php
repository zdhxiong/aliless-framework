<?php

declare(strict_types=1);

namespace Aliless;

class Response
{
    /**
     * 响应状态码
     *
     * @var int
     */
    protected $status;

    /**
     * 响应头
     *
     * @var array
     */
    protected $headers;

    /**
     * 响应体
     *
     * @var mixed
     */
    protected $body;

    /**
     * @param int        $status
     * @param array|null $headers
     * @param $body
     */
    public function __construct(int $status = null, array $headers = null, $body = null)
    {
        $this->status = $status ?? 200;
        $this->headers = $headers ?? [];
        $this->body = $body;
    }

    /**
     * 获取响应状态码
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * 设置响应状态码
     *
     * @param  int  $code
     * @return self
     */
    public function withStatus(int $code): self
    {
        $this->status = $code;

        return $this;
    }

    /**
     * 获取响应头
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * 设置响应头
     *
     * @param  string          $name
     * @param  string|string[] $value
     * @return self
     */
    public function withHeader(string $name, $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * 获取响应体
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * 设置响应体
     *
     * @param  $body
     * @return self
     */
    public function withBody($body): self
    {
        $this->body = $body;

        return $this;
    }
}
