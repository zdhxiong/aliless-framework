<?php

declare(strict_types=1);

namespace Aliless;

class App
{
    /**
     * 容器实例
     *
     * @var Container
     */
    protected $container;

    /**
     * @param string    $event     来自 API 网关的参数
     * @param array     $context   函数的运行时信息
     * @param Container $container 如果自己实现了容器实例，把实例传入
     */
    public function __construct(string $event, array $context, Container $container = null)
    {
        if ($container) {
            $container->offsetSet('event', new Event($event));
            $container->offsetSet('context', new Context($context));

            $this->container = $container;
        } else {
            $this->container = new Container([
                'event' => new Event($event),
                'context' => new Context($context),
            ]);
        }
    }

    /**
     * 执行控制器方法，返回执行结果
     *
     * @return mixed
     */
    protected function runController()
    {
        $pathParameters = $this->container->event->pathParameters;
        $queryParameters = $this->container->event->queryParameters;

        [$controllerName, $actionName] = explode('.', $queryParameters['method']);

        $controllerPath = '\App\\Controller\\' . $controllerName;
        $controller = new $controllerPath($this->container);

        return call_user_func([$controller, $actionName], ...array_values($pathParameters));
    }

    /**
     * 执行
     *
     * @return string
     */
    public function run()
    {
        $responseBody = $this->runController();

        return ResponseEmitter::emit($responseBody);
    }
}
