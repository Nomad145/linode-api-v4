[![Build Status](https://travis-ci.org/Nomad145/linode-api-v4.svg?branch=master)](https://travis-ci.org/Nomad145/linode-api-v4)
[![codecov](https://codecov.io/gh/Nomad145/linode-api-v4/branch/master/graph/badge.svg)](https://codecov.io/gh/Nomad145/linode-api-v4)

```
<?php

use LinodeApi\Auth\AccessToken;
use GuzzleHttp\Psr7\Request;
use LinodeApi\Middleware\AccessTokenMiddleware;
use LinodeApi\Middleware\JsonContentTypeMiddleware;
use LinodeApi\Factory\GuzzleFactory;

require 'vendor/autoload.php';

$accessToken = new AccessToken('access_token');

$middleware[] = new JsonContentTypeMiddleware();
$middleware[] = new AccessTokenMiddleware($accessToken);

$factory = new GuzzleFactory('https://api.alpha.linode.com/v4/');
$client = $factory->create($middleware);

$body = [
    'region' => 'us-east-1a',
    'type' => 'g5-standard-1'
];

$request = new Request('POST', 'linode/instances', array(), json_encode($body));
/* $request = new Request('GET', 'linode/instances'); */

$response = $client->send($request);
echo $var = (string) $response->getBody();

```
