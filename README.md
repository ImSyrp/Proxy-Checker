# ProxyChecker

## 🛠️ Overview

`ProxyChecker` is a PHP class designed to validate and verify the status of proxies. It supports both **authenticated** and **non-authenticated proxies** and logs any errors encountered during the validation process. The class utilizes cURL to check proxy connections against specific URLs and provides helpful outputs such as **obfuscated IPs** for privacy purposes.

---

## 📂 Project Structure

/logs/proxyError/         # Directory for logging proxy-related errors
/helpers/                 # Contains proxy data files (like 'dataimpulse.txt')
/error.log                # Error log for general PHP errors

---

## 🚀 Features

- **Supports both authenticated (user:pass) and non-authenticated proxies.**
- **Logs proxy errors** with timestamps into specific log directories.
- **Random proxy selection** from a list or file.
- **Verifies IPs** using multiple external services.
- **Obfuscates IPs** for privacy (e.g., `192.168.1.1` becomes `192.x.x.1`).
- **cURL-based verification** to test the validity and availability of proxies.

---

## 🧰 Requirements

- PHP 7.4 or higher
- cURL enabled on your server
- Write permissions to the `logs/` directory

---

## 📖 Code Example

# Example 1: Using a Custom Proxy List

```PHP
<?php

require_once 'ProxyChecker.php';

// Initialize the ProxyChecker class.
$proxyChecker = new ProxyChecker();

// Example proxy list.
$proxyList = [
    'brd.superproxy.io:22225:username:password',
    '192.168.1.1:8080'
];

// Check proxies using the custom list.
$result = $proxyChecker->checkProxy($proxyList, 3); // 3 retries

// Display the result.
var_dump($result);

?>
```

## Expected Output:
```bash
array(4) {
  ["success"]=> bool(true)
  [0]=> string(18) "LIVE! 192.x.x.25"
  ["proxyData"]=> array(4) {
    ["proxy"]=> string(21) "192.168.1.1:8080"
    ["ip"]=> string(12) "192.168.1.1"
    ["port"]=> string(4) "8080"
  }
  ["Curl"]=> array(3) {
    ["METHOD"]=> string(6) "TUNNEL"
    ["SERVER"]=> string(21) "192.168.1.1:8080"
  }
}
```
---

# Example 2: Without Providing a Proxy List (Using Default List in the Class)

```PHP
<?php

require_once 'ProxyChecker.php';

// Initialize the ProxyChecker class.
$proxyChecker = new ProxyChecker();

// Check proxies using the default list from the class.
$result = $proxyChecker->checkProxy([], 5); // 5 retries

// Display the result.
var_dump($result);

?>
```

## Expected Output:

```Bash
array(4) {
  ["success"]=> bool(false)
  [0]=> string(42) "Proxy connection failed after 5 attempts."
  ["proxyData"]=> NULL
}
```
