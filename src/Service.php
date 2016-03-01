<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/1
 * Time: 16:08
 */
namespace HuNanZai\Component\Config;

use HuNanZai\Component\Config\Handler\StringParamHandler;

class Service
{
    /**
     * @var Resource
     */
    private static $config  = null;

    public static function setConfig(Resource $config)
    {
        self::$config   = $config;
    }

    public static function getConfig(Param $param)
    {
        $config = self::$config->value;

        while ($param) {
            if (isset($config[$param->value])) {
                $config = $config[$param->value];
                $param  = $param->next;
            } else {
                return null;
            }
        }
        return $config;
    }

    public static function getConfigByString($param_string)
    {
        $handler    = new StringParamHandler($param_string);

        return self::getConfig($handler->getParam());
    }
}
