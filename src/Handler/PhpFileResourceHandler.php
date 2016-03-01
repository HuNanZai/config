<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/1
 * Time: 14:57
 */
namespace HuNanZai\Component\Config\Handler;

use HuNanZai\Component\Config\Resource;
use HuNanZai\Component\Config\Exception\InvalidParamException;

class PhpFileResourceHandler
{
    private $resource_folder_path = '';

    public function __construct($resource_folder_path = '')
    {
        if (!is_dir($resource_folder_path)) {
            throw new InvalidParamException('folder', $resource_folder_path);
        }
        $this->resource_folder_path  = $resource_folder_path;
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        $config = new Resource();
        $config->value  = $this->getResourceArrayFromDirectory($this->resource_folder_path);
        return $config;
    }

    private function getResourceArrayFromDirectory($directory)
    {
        $config_array   = array();
        $iterator   = new \DirectoryIterator($directory);

        foreach ($iterator as $info) {
            $base_name  = $info->getBasename();
            $real_path  = $info->getRealPath();

            if ($info->isFile() && $info->getExtension() == 'php' && $info->isReadable()) {
                $tmp    = explode('.', $base_name);
                $config_array[$tmp[0]]  = include_once "{$real_path}";
            } elseif ($info->isDir() && !$info->isDot()) {//遍历读取文件夹配置
                $config_array[$base_name]   = $this->getResourceArrayFromDirectory($real_path);
            }
        }

        return $config_array;
    }
}
