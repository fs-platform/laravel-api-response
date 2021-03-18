<?php

namespace Aron\Response\Traits;

trait ResponseStatusTrait
{
    /**
     * @var string 成功状态返回信息
     */
    public static string $successStatus = 'success';
    /**
     * @var string 失败状态返回信息
     */
    public static string $errorStatus = 'error';
}
