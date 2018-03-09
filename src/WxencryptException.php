<?php
/**
 * @Author: Marte
 * @Date:   2018-03-08 18:50:04
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-03-08 18:57:49
 */
namespace wxencrypt;

class WxencryptException extends \Exception
{
    protected $errcode;
    protected $errmsg;

    public function __construct(array $errcode)
    {
        $this->errcode = $errcode[0];
        $this->errmsg = $errcode[1];
    }

    public function getMessages()
    {
        $res = [
            'errcode' => $this->errcode,
            'errmsg'  => $this->errmsg,
        ];
        return $res;
    }
}