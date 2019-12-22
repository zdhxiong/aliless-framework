<?php

declare(strict_types=1);

namespace Aliless;

class View
{
    /**
     * 模板目录
     *
     * @var string
     */
    protected $templatePath = __DIR__ . '/../../../../../src/Template';

    /**
     * 模板数据
     *
     * @var array
     */
    protected $attributes;

    /**
     * 获取模板数据
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * 设置模板数据
     *
     * @param  array $attributes
     * @return self
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * 添加模板数据
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function addAttribute(string $key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * 获取指定模板数据
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        if (!isset($this->attributes[$key])) {
            return false;
        }

        return $this->attributes[$key];
    }

    /**
     * 获取模板目录
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * 设置模板目录
     *
     * @param  string $templatePath
     * @return self
     */
    public function setTemplatePath($templatePath): self
    {
        $this->templatePath = rtrim($templatePath, '/\\') . '/';

        return $this;
    }

    /**
     * 渲染模板，并返回渲染和的模板内容
     *
     * @param string $template
     * @param array  $data
     *
     * @return string
     */
    public function fetch(string $template, array $data = []): string
    {
        $data = array_merge($this->attributes, $data);

        ob_start();
        $this->protectedIncludeScope($this->templatePath . $template, $data);
        $output = ob_get_clean();

        return $output;
    }

    /**
     * @param string $template
     * @param array $data
     */
    protected function protectedIncludeScope($template, array $data) {
        extract($data);
        include func_get_arg(0);
    }
}
