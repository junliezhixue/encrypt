<?php
/**
 * 随机字符串类
 * @Author: Marte
 * @Date:   2018-03-08 19:12:21
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-03-08 19:14:17
 */
namespace wxencrypt;

class RandowStr
{
    /**
     * 随机生成16位字符串
     * @return string 生成的字符串
     */
    public function getRandomStr()
    {

        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }
}