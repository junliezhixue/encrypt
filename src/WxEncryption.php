<?php
namespace wxencrypt;
use wxencrypt\Prpcrypt;
use wxencrypt\ErrorCode;
use wxencrypt\RandowStr;
use wxencrypt\WxencryptException;

/**
 * 1.第三方回复加密消息给公众平台；
 * 2.第三方收到公众平台发送的消息，验证消息的安全性，并对消息进行解密。
 */
class WxEncryption
{
	private $appId;
	private $token;
	private $encodingAesKey;

	/**
	 * 构造函数
	 * @param $token string 公众平台上，开发者设置的token
	 * @param $encodingAesKey string 公众平台上，开发者设置的EncodingAESKey
	 * @param $appId string 公众平台的appId
	 */
	public function __construct($appId, $token, $encodingAesKey)
	{
		$this->appId = $appId;
		$this->token = $token;
		$this->encodingAesKey = $encodingAesKey;
	}

	/**
	 * 将公众平台回复用户的消息加密打包.
	 * @param $replyMsg string 公众平台待回复用户的消息，xml格式的字符串
	 * @param $timeStamp string 时间戳，可以自己生成，也可以用URL参数的timestamp
	 * @param $nonce string 随机串，可以自己生成，也可以用URL参数的nonce
	 * @param $cryptMode 加密模式
	 * @author 	qidongbo
	 * @date 	2018/3/8
	 */
	public function encryptMsg($replyMsg, $timeStamp='', $nonce='', $cryptMode='openssl')
	{
		$pc = new Prpcrypt($this->encodingAesKey);
		//加密
		$encrypt = $pc->encrypt($replyMsg, $this->appId, $cryptMode);;
		//时间戳处理
		if ($timeStamp === '') {
			$timeStamp = time();
		}
		//随机串处理
		if ($nonce === '') {
			$nonce = $this->getRandomStr();
		}
		//生成安全签名
		$signature = $this->getSHA1($this->token, $timeStamp, $nonce, $encrypt);
		return array(
			"signature" => $signature,
            "encrypt"   => $encrypt,
            "timestamp" => $timeStamp,
            "nonce"     => $nonce
		);
	}


	/**
	 * 检验消息的真实性，并且获取解密后的明文.
	 * @param $msgSignature string 签名串，对应URL参数的msg_signature
	 * @param $timestamp string 时间戳 对应URL参数的timestamp
	 * @param $nonce string 随机串，对应URL参数的nonce
	 * @param $postData string 密文，对应POST请求的数据
	 * @param $cryptMode 加密模式
	 * @author 	qidongbo
	 * @date 	2018/3/8
	 */
	public function decryptMsg($msgSignature, $postData, $timestamp='', $nonce='', $cryptMode='openssl')
	{
		//验证非法
		if (strlen($this->encodingAesKey) != 43) {
			throw new WxencryptException(ErrorCode::$IllegalAesKey);
		}
		//时间戳处理
		if ($timestamp === '') {
			$timestamp = time();
		}
		//随机串处理
		if ($nonce === '') {
			$nonce = $this->getRandomStr();
		}
		//验证安全签名
		$signature = $this->getSHA1($this->token, $timestamp, $nonce, $postData);
		if ($signature != $msgSignature) {
			throw new WxencryptException(ErrorCode::$ValidateSignatureError);
		}
		//解密
		$pc = new Prpcrypt($this->encodingAesKey);
		return $pc->decrypt($postData, $this->appId, $cryptMode);
	}

	/**
	 * 用SHA1算法生成安全签名
	 * @param string $token 票据
	 * @param string $timestamp 时间戳
	 * @param string $nonce 随机字符串
	 * @param string $encrypt 密文消息
	 */
	private function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
	{
		//排序
		try {
			$array = array($encrypt_msg, $token, $timestamp, $nonce);
			sort($array, SORT_STRING);
			$str = implode($array);
			return sha1($str);
		} catch (Exception $e) {
			throw new WxencryptException(ErrorCode::$ComputeSignatureError);
		}

	}
}

