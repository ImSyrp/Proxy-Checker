<?php

$whatprx = rand(0,0);
$hmuch = 10;
$whatprx = 0;
$prx_param0 = 0;
$prx_param1 = 1;
$linkprx1 = 'https://ip.smartproxy.com/json';
$linkprx = 'https://lumtest.com/myip.json';

function getProxy($whatprx){

	if($whatprx == 0){

	$botproxylist = array(
	// 170417
	'38.153.65.211:8800',
	'38.152.145.28:8800',
	'38.153.18.88:8800',
	'38.153.65.195:8800',
	'38.153.18.52:8800',
	'38.152.145.68:8800',
	'38.153.18.99:8800',
	'38.152.145.137:8800',
	'38.152.145.228:8800',
	'38.153.18.198:8800',
	// 170416
	'38.154.123.254:8800',
	'38.154.123.176:8800',
	'38.153.18.218:8800',
	'38.153.18.71:8800',
	'38.153.18.61:8800',
	'38.153.18.15:8800',
	'38.154.123.229:8800',
	'38.152.189.130:8800',
	'170.130.66.219:8800',
	'38.154.123.234:8800',
	// 170415
	'38.152.157.190:8800',
	'38.152.137.17:8800',
	'38.152.137.60:8800',
	'38.154.104.52:8800',
	'38.152.157.191:8800',
	'38.152.157.234:8800',
	'38.154.104.44:8800',
	'38.152.137.98:8800',
	'38.152.137.64:8800',
	'38.152.157.154:8800',
		);

		$link1 = $botproxylist[array_rand($botproxylist)];

		$explodeupass = explode(':', $link1);
		$proxynm = $explodeupass['0'];
		$proxyport = $explodeupass['1'];
		return json_encode(array('link' => $link1, 'ip' => $proxynm, 'port' => $proxyport));

	}elseif($whatprx == 1){

		$botproxyuplist = array(
			'zproxy.lum-superproxy.io:22225:brd-customer-hl_441e5d89-zone-residential:j413y43isps5',
			'zproxy.lum-superproxy.io:22225:brd-customer-hl_441e5d89-zone-isp:99q2s58q10is',
			'zproxy.lum-superproxy.io:22225:brd-customer-hl_441e5d89-zone-mobile:z57hy6l3tj2w',
			'open.proxymesh.com:31280:Lamar1299:Lamar_1299',
		);

		$botproxyuplist = $botproxyuplist[array_rand($botproxyuplist)];
		$explodeupass = explode(':', $botproxyuplist);
		$proxynm = $explodeupass['0'];
		$proxyport = ''.$explodeupass['0'].':'.$explodeupass['1'].'';
		$proxyuserpass = ''.$explodeupass['2'].':'.$explodeupass['3'].'';
		$proxypass = $explodeupass['2'];
		$proxyuser = $explodeupass['3'];
		$link1 = $proxyport;
		$proxy1 = $proxyuserpass;
		return json_encode(array('link' => $link1, 'userpass' => $proxy1, 'user' => $proxyuser, 'pass' => $proxypass));
	}elseif($whatprx == 2){

		$botproxylist = array(
		// 172379
		'185.210.41.178:8800',
		'185.210.41.173:8800',
		'185.223.41.249:8800',
		'185.210.41.57:8800',
		'185.223.41.250:8800',
		'185.210.41.128:8800',
		'185.210.41.99:8800',
		'185.223.41.32:8800',
		'185.223.41.213:8800',
		'185.210.41.202:8800',
	    // 172380
		'185.210.41.210:8800',
		'185.223.41.25:8800',
		'185.210.41.189:8800',
		'185.223.41.71:8800',
		'185.210.41.200:8800',
		'185.223.41.209:8800',
		'185.210.41.246:8800',
		'185.223.41.152:8800',
		'185.210.41.137:8800',
		'185.210.41.240:8800',
		// 172381
		'185.223.41.218:8800',
		'185.210.41.89:8800',
		'185.223.41.203:8800',
		'185.223.41.195:8800',
		'185.223.41.192:8800',
		'185.223.41.28:8800',
		'185.223.41.227:8800',
		'185.223.41.102:8800',
		'185.223.41.10:8800',
		'185.223.41.113:8800',
		// 172382
		'185.223.41.15:8800',
		'185.223.41.179:8800',
		'185.223.41.100:8800',
		'185.223.41.137:8800',
		'185.223.41.61:8800',
		'185.223.41.36:8800',
		'185.223.41.172:8800',
		'185.223.41.208:8800',
		'185.223.41.237:8800',
		'185.223.41.151:8800',
		// 172383
		'196.51.232.91:8800',
		'196.51.235.171:8800',
		'196.51.235.81:8800',
		'196.51.235.241:8800',
		'196.51.235.89:8800',
		'196.51.232.27:8800',
		'196.51.234.14:8800',
		'196.51.234.21:8800',
		'38.154.105.245:8800',
		'38.154.105.200:8800',
		// pinko
		'185.158.68.144:8800',
		'154.9.43.114:8800',
		'185.158.68.24:8800',
		'107.150.0.194:8800',
		'185.158.68.23:8800',
		'154.9.43.130:8800',
		'154.9.40.28:8800',
		'107.150.0.36:8800',
		'185.158.68.68:8800',
		'154.9.40.93:8800',
			);
	
			$link1 = $botproxylist[array_rand($botproxylist)];
	
			$explodeupass = explode(':', $link1);
			$proxynm = $explodeupass['0'];
			$proxyport = $explodeupass['1'];
			return json_encode(array('link' => $link1, 'ip' => $proxynm, 'port' => $proxyport));
	
		}elseif($whatprx == 4){

			$botproxyuplist = array(
				'open.proxymesh.com:31280:Lamar1299:Lamar_1299',
			);

			$botproxyuplist = $botproxyuplist[array_rand($botproxyuplist)];
			$explodeupass = explode(':', $botproxyuplist);
			$proxynm = $explodeupass['0'];
			$proxyport = ''.$explodeupass['0'].':'.$explodeupass['1'].'';
			$proxyuserpass = ''.$explodeupass['2'].':'.$explodeupass['3'].'';
			$proxypass = $explodeupass['2'];
			$proxyuser = $explodeupass['3'];
			$link1 = $proxyport;
			$proxy1 = $proxyuserpass;
			return json_encode(array('link' => $link1, 'userpass' => $proxy1, 'user' => $proxyuser, 'pass' => $proxypass));
		}
}
