<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/1
 * Time: 14:13
 */
namespace HuNanZai\Component\Config\Handler;

use HuNanZai\Component\Config\Exception\InvalidParamException;
use HuNanZai\Component\Config\Param;

class StringParamHandler
{
    const STRING_SPLIT_FLAG = '.';

    private $param_string = '';

    public function __construct($input_string)
    {
        if (!is_string($input_string) || strlen($input_string) <= 0) {
            throw new InvalidParamException('string', $input_string);
        }

        $this->param_string   = $input_string;
    }

    /**
     * @return Param
     */
    public function getParam()
    {
        $tmp    = explode(self::STRING_SPLIT_FLAG, $this->param_string);

        $first  = null;
        $point  = null;
        foreach ($tmp as $v) {
            $test   = new Param();
            $test->value    = $v;

            if ($point) {
                $point->next    = $test;
                $point          = $point->next;
            } else {
                $point  = $test;
                $first  = $point;
            }
        }
        return $first;
    }
}
