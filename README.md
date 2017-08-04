[![Build Status](https://travis-ci.org/Nomad145/linode-api-v4.svg?branch=master)](https://travis-ci.org/Nomad145/linode-api-v4)
[![codecov](https://codecov.io/gh/Nomad145/linode-api-v4/branch/master/graph/badge.svg)](https://codecov.io/gh/Nomad145/linode-api-v4)

# Linode API

Create an instance of the Guzzle Client.  This configures the Authentication
Middleware so you could optionally work with only the GuzzleClient if you
preferred.

```
$factory = new GuzzleFactory();
$accessToken = new AccessToken('insert-access-token-here');
$middleware[] = new JsonContentTypeMiddleware();
$middleware[] = new AccessTokenMiddleware($accessToken);
$client = $factory->getClient('https://api.alpha.linode.com/v4/', $middleware);
```

Initialize the model.

```
AbstractModel::setClient($client);
```

Creating a new Linode is as simple as calling Linode::save();

```
$linode = new Linode();
$linode->region = 'us-east-1a';
$linode->type = 'g5-standard-1';
$linode->distribution = 'linode/Fedora25';
$linode->root_pass = 'asdf123;';
$linode->save();
```

Issue commands to the Linode.
```
$linode->boot();
$linode->createBackup("Tuesday's Backup");
```

Fetch a Linode.

```
$linode = Linode::find(1);
```

Associations are automatically hydrated.
```
$linode->type; // LinodeApi\Model\Type
```
