<?php
namespace wxencrypt;

/**
 * error code 说明.
 * <ul>
 *    <li>-40001: 签名验证错误</li>
 *    <li>-40002: xml解析失败</li>
 *    <li>-40003: sha加密生成签名失败</li>
 *    <li>-40004: encodingAesKey 非法</li>
 *    <li>-40005: appid 校验错误</li>
 *    <li>-40006: aes 加密失败</li>
 *    <li>-40007: aes 解密失败</li>
 *    <li>-40008: 解密后得到的buffer非法</li>
 *    <li>-40009: base64加密失败</li>
 *    <li>-40010: base64解密失败</li>
 *    <li>-40011: 生成xml失败</li>
 *    <li>-40011: xml参数错误</li>
 * </ul>
 */
class ErrorCode
{
	public static $ValidateSignatureError  		= [40001, '签名验证错误'];
	public static $ParseXmlError 				= [40002, 'xml解析失败'];
	public static $ComputeSignatureError 		= [40003, 'sha加密生成签名失败'];
	public static $IllegalAesKey 				= [40004, 'encodingAesKey非法'];
	public static $ValidateAppidError 			= [40005, 'appid校验错误'];
	public static $EncryptAESError 				= [40006, 'aes加密失败'];
	public static $DecryptAESError 				= [40007, 'aes解密失败'];
	public static $IllegalBuffer 				= [40008, '解密后得到的buffer非法'];
	public static $EncodeBase64Error 			= [40009, 'base64加密失败'];
	public static $DecodeBase64Error 			= [40010, 'base64解密失败'];
	public static $GenReturnXmlError 			= [40011, '生成xml失败'];
	public static $XmlParamError 				= [40012, 'xml参数错误'];
}

?>