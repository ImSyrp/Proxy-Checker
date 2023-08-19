<?php
echo'hola';return;
$linkprx = 'https://lumtest.com/myip.json';
$hmuch = 10;
$tries = 0;
$ip = "Inactive!";

// Agrega tu lógica para verificar whatprx y manejar la excepción de valor 3
$whatprx = rand(0, 4); // O cualquier otra lógica que necesites
$linkprx1 = 'https://ip.smartproxy.com/json';

function getProxy($proxyList, $type) {
    $randomProxy = $proxyList[array_rand($proxyList)];
    $proxyParts = explode(':', $randomProxy);
    $ip = $proxyParts[0];
    $port = $proxyParts[1];
    $userpass = isset($proxyParts[2]) ? $proxyParts[2] : '';

    if ($type == 'http') {
        $proxyData = [
            'ip' => $ip,
            'port' => $port
        ];
    } elseif ($type == 'http_with_auth') {
        $proxyData = [
            'ip' => $ip,
            'port' => $port,
            'userpass' => $userpass
        ];
    }

    return $proxyData;
}

function testProxy($linkprx, $proxyData, $type) {
    $ch = curl_init($linkprx);

    if ($type == 'http') {
        $proxy = $proxyData['ip'] . ':' . $proxyData['port'];
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PROXY => $proxy,
            CURLOPT_TIMEOUT => 2,
            CURLOPT_HTTPGET => true,
            CURLOPT_CONNECTTIMEOUT => 5,
        ]);
    } elseif ($type == 'http_with_auth') {
        $proxy = $proxyData['ip'] . ':' . $proxyData['port'];
        $userpass = $proxyData['userpass'];
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PROXY => $proxy,
            CURLOPT_PROXYUSERPWD => $userpass,
            CURLOPT_TIMEOUT => 2,
            CURLOPT_HTTPGET => true,
            CURLOPT_CONNECTTIMEOUT => 5,
        ]);
    }

    $ipData = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    return $ipData;
}

$proxyListHttp = [
    '123.456.789.1:8080',
    '987.654.321.2:8888',
    '192.168.0.1:3128',
    // Agrega más proxies aquí
];

$proxyListHttpWithAuth = [
    'username:password@123.456.789.1:8080',
    'user123:pass456@987.654.321.2:8888',
    'admin:securepass@192.168.0.1:3128',
    // Agrega más proxies aquí
];

if ($whatprx != 3) {
    while ($tries < $hmuch) {
        if ($tries > 0) {
            $whatprx = rand(0, 1);
        } else {
            $whatprx = 0;
        }

        if ($whatprx == 0) {
            $proxyData = getProxy($proxyListHttp, 'http');
        } elseif ($whatprx == 1) {
            $proxyData = getProxy($proxyListHttpWithAuth, 'http_with_auth');
        }

        $ipData = testProxy($linkprx, $proxyData, ($whatprx == 0) ? 'http' : 'http_with_auth');

        if ($ipData) {
            $st = "LIVE!";
            break;
        } else {
            $st = "DEAD!";
            $tries++;

            if ($tries == $hmuch) {
                echo "Proxy connection failed after $tries attempts.\n";
            }
        }
    }

    $prx = preg_replace("/\.\d+\.\d+\./", ".x.x.", $ipData);
    $ip = "$st $prx";
} else {
    $ip = "Proxy check disabled for value 3.";
}

echo $ip;
?>
