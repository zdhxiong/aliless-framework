<?php

declare(strict_types=1);

namespace Aliless;

class ResponseEmitter
{
    /**
     * 获取响应对象
     *
     * @param  mixed $data
     * @return Response
     */
    protected static function getResponse($data): Response
    {
        if ($data instanceof Response) {
            return $data;
        }

        if (is_array($data)) {
            return new Response(200, ['Content-Type' => 'application/json'], json_encode($data));
        }

        return new Response(200, ['Content-Type' => 'text/html'], $data);
    }

    /**
     * 生成 API 网关事件源的响应
     *
     * @param  mixed  $data
     * @return string
     */
    public static function emit($data): string
    {
        $response = self::getResponse($data);

        return json_encode([
            'isBase64Encoded' => true,
            'statusCode' => $response->getStatus(),
            'headers' => $response->getHeaders(),
            'body' => base64_encode($response->getBody()),
        ]);
    }
}
