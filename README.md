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

## ⚙️ Usage Instructions

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-username/proxy-checker.git
cd proxy-checker
