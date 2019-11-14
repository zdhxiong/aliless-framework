<?php

declare(strict_types=1);

namespace Aliless;

use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * 容器实例
     *
     * @var Container
     */
    protected $container;

    /**
     * 是否是 API 网关事件源
     *
     * @var bool
     */
    protected $isApiEvent = false;

    /**
     * 是否是 HTTP 触发器事件源
     *
     * @var bool
     */
    protected $isHttpEvent = false;

    /**
     * @param string|ServerRequestInterface $event
     * @param array                         $context
     */
    public function __construct($event, array $context)
    {
        if ($event instanceof ServerRequestInterface) {
            $this->isHttpEvent = true;
        } else {
            $eventDecode = json_decode($event, true);
        }

        if (isset($eventDecode['isBase64Encoded'])) {
            $this->isApiEvent = true;
            $eventDecode = $this->parseApiEventBody($eventDecode);
        }

        $this->container = new Container([
            'event' => $eventDecode ?? $event,
            'context' => $context,
        ]);
    }

    /**
     * 获取容器
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * 解析 API 网关事件源中的 body
     *
     * @param  array $event
     * @return array
     */
    protected function parseApiEventBody(array $event): array
    {
        if ($event['isBase64Encoded']) {
            $event['body'] = base64_decode($event['body']);
        }

        if (strstr($event['headers']['Content-Type'], 'application/json')) {
            $event['body'] = json_decode($event['body'], true);
        }

        return $event;
    }

    /**
     * 执行控制器方法，返回执行结果
     *
     * @return mixed
     */
    protected function runController()
    {
        $event = $this->container->event;

        $queryMethod = $event['queryParameters']['method'] ?? '';
        [$controllerName, $actionName] = explode('.', $queryMethod);

        $controllerPath = '\App\\Controller\\' . ($controllerName ? $controllerName : 'Handler');
        $controller = new $controllerPath($this->container);

        // 对于 API 网关触发器事件，把 pathParameters 作为方法参数传入
        $actionParameters = $this->isApiEvent ? $event['pathParameters'] : [];

        $responseBody = $actionName
            ? call_user_func([$controller, $actionName], ...array_values($actionParameters))
            : $controller(...array_values($actionParameters));

        return $responseBody;
    }

    /**
     * 执行
     *
     * @return string
     */
    public function run()
    {
        $responseBody = $this->runController();

        if ($this->isApiEvent) {
            return ResponseEmitter::emitForApiEvent($responseBody);
        }

        if ($this->isHttpEvent) {
            return ResponseEmitter::emitForHttpEvent($responseBody);
        }

        return null;
    }
}
