<?php

// This class checks proxies and performs verification of their status.
class ProxyChecker
{
    // List of proxy sources (can be files or direct proxies).
    private $proxies = [
        'path/to/your/proxylist.txt', // LIST IN TXT
        'brd.superproxy.io:22225:username:password', // HOST:POST:USERNAME:PASSWORD
        '192.168.1.1:8080', // IP:PORT
    ];

    // URLs used to verify if a proxy is working, based on specific keywords in the proxy address.
    private $verificationUrls = [
        'p.tokenu.to' => 'http://ip-api.com/json',
        'brd.superproxy.io' => 'https://ip.smartproxy.com/json',
        'rp.proxyscrape.com' => 'https://lumtest.com/myip.json',
        'brd.superproxy.io' => 'https://lumtest.com/myip.json'
    ];

    // Logs any proxy-related errors into a dedicated directory with timestamps.
    private function proxyError(string $errorMessage) : void
    {
        $logDirectory = __DIR__ . '/logs/proxyError/' . date('Y-m-d') . '/';
        $logFilePath = $logDirectory . 'error.log';

        // Create the log directory if it does not exist.
        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        // Write the error message to the log file.
        file_put_contents($logFilePath, date('Y-m-d H:i:s') . ' - ' . $errorMessage . PHP_EOL, FILE_APPEND);
    }

    // Obfuscates part of the IP address for privacy (e.g., converts 192.168.1.1 to 192.x.x.1).
    public static function obfuscateIP(string $ip) : string
    {
        return preg_replace("/\.\d+\.\d+\./", ".x.x.", $ip);
    }

    // Returns the list of proxies.
    public function getProxyList() : array
    {
        return $this->proxies;
    }

    // Randomly selects an element from an array.
    public static function randArray(array $array) : string
    {
        return $array[array_rand($array)];
    }

    // Retrieves a random line from a file.
    public static function GetRandVal(string $file) : string
    {
        $_ = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $_[array_rand($_)];
    }

    // Checks whether the proxy uses username/password authentication or not.
    private function checkProxyType(string $proxy) : string
    {
        if (preg_match('/^(https?:\/\/)?[^:]+:[^:]+:[^:]+:[^:]+$/', $proxy)) {
            return 'userpass'; // Proxy with authentication.
        } else {
            return 'nopass'; // Proxy without authentication.
        }
    }

    // Decodes the proxy string into its components (IP, port, user, pass).
    public function decodeProxy(string $proxy) : array
    {
        $proxy = preg_replace('#^https?://#', '', $proxy); // Remove 'http://' or 'https://' if present.
        $proxyParts = explode(':', $proxy); // Split proxy string by colon (:).
        $ip = $proxyParts[0];
        $port = $proxyParts[1];

        // Check if the proxy has user credentials.
        if (count($proxyParts) > 2) {
            $proxyuser = $proxyParts[2];
            $proxypass = $proxyParts[3];

            // Return data with authentication.
            return [
                'type' => 'userpass',
                'data' => [
                    'proxy' => $ip . ":" . $port,
                    'ip' => $ip,
                    'port' => $port,
                    'user' => $proxyuser,
                    'pass' => $proxypass,
                    'userpass' => $proxyuser . ":" . $proxypass,
                ],
                'Curl' => [
                    "METHOD" => "CUSTOM",
                    "SERVER" => $ip . ":" . $port,
                    "AUTH" => $proxyuser . ":" . $proxypass
                ]
            ];
        } else {
            // Return data without authentication.
            return [
                'type' => 'ipport',
                'data' => [
                    'proxy' => $ip . ":" . $port,
                    'ip' => $ip,
                    'port' => $port
                ],
                'Curl' => [
                    "METHOD" => "TUNNEL",
                    "SERVER" =>  $ip . ":" . $port,
                ]
            ];
        }
    }

    // Selects a verification URL based on keywords in the proxy.
    public function getVerificationUrl(string $proxy) : string
    {
        foreach ($this->verificationUrls as $keyword => $url) {
            if (strpos($proxy, $keyword) !== false) {
                return $url; // Return the URL matching the keyword.
            }
        }

        // Default URL if no keyword matches.
        return 'https://api.ipify.org/?format=json';
    }

    // Performs a cURL request to test the proxy.
    private function cURL_Proxy(string $proxy, string $proxyType) : array
    {
        $verificationUrl = $this->getVerificationUrl($proxy); // Get the correct verification URL.
        $proxyData = $this->decodeProxy($proxy); // Decode the proxy into its components.

        $ch = curl_init($verificationUrl); // Initialize cURL.
        if ($proxyType === 'userpass') {
            curl_setopt($ch, CURLOPT_PROXY, $proxyData['data']['proxy']); // Set proxy.
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyData['data']['userpass']); // Set authentication.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response.
        } else {
            curl_setopt($ch, CURLOPT_PROXY, $proxyData['data']['proxy']); // Set proxy without authentication.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response.
        }

        $response = curl_exec($ch); // Execute the cURL request.
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP response code.

        // Handle errors if the cURL request fails.
        if ($response === false) {
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            curl_close($ch); // Close the cURL handle.
            $this->proxyError("cURL errorProxyChk: $response (Error: $error, Code: $errno, httpCode: $httpCode), Format: $proxy");

            return [
                'success' => false,
                'response' => 'cURL errorProxyChk (' . $httpCode . '), on: ' . date('Y-m-d'),
                'httpCode' => $httpCode,
                'ipValue' => null
            ];
        }

        curl_close($ch); // Close the cURL handle.

        $decodedResponse = json_decode($response, true); // Decode the JSON response.
        if ($decodedResponse === null) {
            $this->proxyError("JSON Decode errorProxyChk: " . json_last_error_msg() . " Respuesta: $response");

            return [
                'success' => false,
                'response' => 'errorProxyChk, on JSON Decode: ' . date('Y-m-d'),
                'httpCode' => $httpCode,
                'ipValue' => null
            ];
        }

        // Extract the IP address from the JSON response.
        $ipKeys = ['ip', 'query', 'address', 'proxy_ip'];
        $ipValue = null;

        foreach ($ipKeys as $key) {
            if (isset($decodedResponse[$key])) {
                $ipValue = $decodedResponse[$key];
                break;
            }
        }

        // Handle case where no IP was found in the response.
        if ($ipValue === null) {
            $this->proxyError("No se encontró la dirección IP en la respuesta JSON.");
            return [
                'success' => false,
                'response' => 'No IP found in cURLJson, on: ' . date('Y-m-d'),
                'httpCode' => $httpCode,
                'ipValue' => null
            ];
        }

        $obfuscatedIP = $this->obfuscateIP($ipValue); // Obfuscate the IP address.

        return [
            'success' => true,
            'response' => $response,
            'httpCode' => $httpCode,
            'ipValue' => $ipValue,
            'obfuscatedIP' => $obfuscatedIP,
            'proxies' => $proxyData['CurlX']
        ];
    }

    // Main function to check proxies with retries.
    public function checkProxy(array $proxyList = [], int $retrys = 10) : array
    {
        if ($retrys === 0) {
            return [
                "success" => true,
                "0" => "OFF!",
                "proxyData" => null,
                "CurlX" => null,
            ];
        }
        if (empty($proxyList)) {
            $proxyList = $this->proxies;
        }

        $proxyFail = "Proxy connection failed after $retrys attempts.";
        $proxyLive = "LIVE!";
        $attempts = 0;

        // Loop to try proxies until success or retries are exhausted.
        do {
            $oneProxy = $this->randArray($proxyList);
            if (is_file($oneProxy)) {
                $oneProxy = $this->GetRandVal($oneProxy);
            }
            $proxyType = $this->checkProxyType($oneProxy);
            $proxyData = $this->cURL_Proxy($oneProxy, $proxyType);
            $attempts++;

            if ($proxyData['success'] === true) {
                $obfuscatedIP = $proxyData['obfuscatedIP'];
                $proxies = $proxyData['proxies'];

                return [
                    "success" => true,
                    "0" => $proxyLive . ' ' . $obfuscatedIP,
                    "proxyData" => $this->decodeProxy($oneProxy)['data'],
                    "CurlX" => $proxies
                ];
            }
        } while ($attempts < $retrys);

        return [
            "success" => false,
            "0" => $proxyFail,
            "proxyData" => null
        ];
    }
}

?>
