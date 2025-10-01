<?php

echo "=== Final Website Test ===\n\n";

$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'ignore_errors' => true,
        'header' => 'User-Agent: TestScript/1.0'
    ]
]);

echo "Testing: http://127.0.0.1:8000\n";
$response = @file_get_contents('http://127.0.0.1:8000', false, $context);

if ($response !== false) {
    echo "✅ SUCCESS: Website is accessible!\n";
    echo "Response length: " . strlen($response) . " characters\n";

    if (strpos($response, 'SedotWC') !== false) {
        echo "✅ Contains brand name: SedotWC\n";
    }
    if (strpos($response, 'Jasa Sedot WC') !== false) {
        echo "✅ Contains service description\n";
    }
    if (strpos($response, 'bootstrap') !== false) {
        echo "✅ Contains Bootstrap CSS\n";
    }
    if (strpos($response, '500 Internal Server Error') === false) {
        echo "✅ No 500 error in response\n";
    }
} else {
    echo "❌ FAILED: Cannot access website\n";

    // Check if server is running
    $fp = @fsockopen('127.0.0.1', 8000, $errno, $errstr, 5);
    if (!$fp) {
        echo "Server might not be running: $errstr ($errno)\n";
    } else {
        echo "Server is running but not responding properly\n";
        fclose($fp);
    }
}

echo "\n=== Test completed ===\n";
