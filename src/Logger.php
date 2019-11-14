<?php

declare(strict_types=1);

namespace Aliless\Dependencies;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * 占位符替换
     *
     * @param string $message
     * @param array  $context
     *
     * @return string
     */
    protected function interpolate($message, array $context = []): string
    {
        $replace = [];

        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }

    /**
     * 记录日志的通用方法
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = []): void
    {
        $logger = $GLOBALS['fcLogger'];
        $message = $this->interpolate($message, $context);

        $logger->{$level}($message);
    }
}
