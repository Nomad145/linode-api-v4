```
<?php

use Nomad145\LinodeAlphaAPI\Client as LinodeClient;
use Nomad145\LinodeAlphaAPI\Auth\AccessToken;
use GuzzleHttp\Client;

require 'vendor/autoload.php';

$accessToken = new AccessToken('access_token');
$guzzle = new Client([
    'base_uri' => 'https://api.alpha.linode.com/v4/'
]);

$client = new LinodeClient($guzzle, $accessToken);
$response = $client->call('GET', 'linode/kernels');
$var = (string) $response->getBody();
```
