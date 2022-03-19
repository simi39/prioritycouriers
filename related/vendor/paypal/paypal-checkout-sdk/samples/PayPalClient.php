<?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment which has access
     * credentials context. This can be used invoke PayPal API's provided the
     * credentials have the access to do so.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }
    
    /**
     * Setting up and Returns PayPal SDK environment with PayPal Access credentials.
     * For demo purpose, we are using SandboxEnvironment. In production this will be
     * ProductionEnvironment.
     */
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "AUTyokDQ0aw42p39EYZuWBKNuFtKuuGbwSnqc1vS415LkPUdz0u2hf1IGx7dUaohCEAgV_jL_O4zZ8F_";
        $clientSecret = getenv("CLIENT_SECRET") ?: "ECY3QiMtlipz2zzcOSXB4tP53M4P6_wqzpYpuRJCF-ZWcrouP6GE2D7R_4G5RddGF41RLsBQMYUHXYY4";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
