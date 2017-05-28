```
<?php

use LinodeApi\Client as LinodeClient;
use LinodeApi\Auth\AccessToken;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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
