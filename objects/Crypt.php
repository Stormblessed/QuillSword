<?php

	class Crypt
	{
		public static function Encrypt($data, $passphrase)
		{
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    		$key = pack('H*', $passphrase . $passphrase);
    		return base64_encode($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_CBC, $iv));
		}
		
		public static function Decrypt($data, $passphrase)
		{
			$data = base64_decode($data);
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
			$iv = substr($data, 0, $iv_size);
			$data = substr($data, $iv_size);
			$key = pack('H*', $passphrase . $passphrase);
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_CBC, $iv), chr(0));
		}
	}

?>