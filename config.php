<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
include_once '../session.php';
require './autoload.php';

// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;
$baseUrl = 'http://localhost/Food/';
// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    'client_id' => 'AZKxLcg06AhT3xE3NGaJNqrod9x5o1z7HRxSoR8uBUQ2YZblCYE9EOFdsWeU8AoXk3cqRQzvBeBEAGkA',
    'client_secret' => 'EKza1Ru4Uua_Jbmml9ZheYYMcCygHBKQdBTkze17JMAvh6WBrsFGY1pm-eZcNXAHikCg8cJZWfKTEIVw',
    'return_url' => $baseUrl . 'payment/response.php',
    'cancel_url' => $baseUrl . 'payment.php',
    'success_url' => $baseUrl . 'payment/PaypalSuccess.php',
    'failed_url' => $baseUrl . 'payment/PaypalFailed.php'

];

// Database settings. Change these for your database configuration.
$dbConfig = [
    'host' => DB_SERVER,
    'username' => DB_USER,
    'password' => DB_PASS,
    'name' => DB_NAME
];

$apiContext = getApiContext($paypalConfig['client_id'], $paypalConfig['client_secret'], $enableSandbox);

/**
 * Set up a connection to the API
 *
 * @param string $clientId
 * @param string $clientSecret
 * @param bool   $enableSandbox Sandbox mode toggle, true for test payments
 * @return \PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret, $enableSandbox = false)
{
    $apiContext = new ApiContext(
        new OAuthTokenCredential($clientId, $clientSecret)
    );

    $apiContext->setConfig([
        'mode' => $enableSandbox ? 'sandbox' : 'live'
    ]);

    return $apiContext;
}
