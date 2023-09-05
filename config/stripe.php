<?php

return [
    'api_keys' => [
        'secret_key' => env('sk_test_51LYTZDKEd5aVpg7arLXqZotAn1pFN6lgnRcaBnSj1eta3p1k1qiJynlYPWehChgTwJrcZw4w09yMppFY1TJBjRE700Y4Z3F9Hc', null)  // Secret KEY: https://dashboard.stripe.com/account/apikeys
    ],
    'client_id' => env('ca_NbaAObHXNzJHA2vUxj0SDgoIknRiJUrG', null),       // Client ID: https://dashboard.stripe.com/account/applications/settings
    'redirect_uri' => env('https://kayndrexsphere_payouts.test', null), // Redirect Uri https://dashboard.stripe.com/account/applications/settings
    'authorization_uri' => 'https://connect.stripe.com/oauth/authorize'
];