<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/1
 * Time: 14:23
 */
namespace HuNanZai\Component\Config\Exception;

class InvalidParamException extends \Exception
{
    public function __construct($expected, $got)
    {
        $this->message  = "expected: {$expected}, got: ".var_export($got, 1);
    }
}
