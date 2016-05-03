<?php
class MY_Input extends CI_Input 
{
	function ip_address()
	{
		$ip = parent::ip_address();
		$proxy = $this->get_request_header('X-Forwarded-For');
 
		if($proxy) // check if there is a proxy being used
		{
			$iplong = ip2long($ip);
 
			// list of IP => mask
			///https://www.cloudflare.com/ips-v4
			$whitelist = array(
				'199.27.128.0' => 21, 
				'173.245.48.0' => 20, 
				'103.21.244.0' => 22, 
				'103.22.200.0' => 22, 
				'103.31.4.0' => 22, 
				'141.101.64.0' => 18, 
				'108.162.192.0' => 18, 
				'190.93.240.0' => 20, 
				'188.114.96.0' => 20, 
				'197.234.240.0' => 22, 
				'1198.41.128.0' => 17, 
				'162.158.0.0' => 15
			);
 
			foreach($whitelist as $whiteip => $mask)
			{
				$bitmask = bindec(str_repeat('1', $mask) . str_repeat('0', 32 - $mask));
				$trusted = ip2long($whiteip);
 
				if(($iplong & $bitmask) == $trusted)
				{
					$ip = $proxy;
					break; 
				}
			}
		}
		return $ip;
	}
}
?>