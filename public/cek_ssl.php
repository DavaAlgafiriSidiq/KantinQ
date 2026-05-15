<?php
// File ini untuk cek konfigurasi PHP yang digunakan Apache
echo "php.ini: " . php_ini_loaded_file() . "\n";
echo "curl.cainfo: " . ini_get('curl.cainfo') . "\n";
echo "SSL test ke Midtrans: ";
$ch = curl_init('https://app.sandbox.midtrans.com');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);
echo $error ? 'ERROR - ' . $error : 'OK';
