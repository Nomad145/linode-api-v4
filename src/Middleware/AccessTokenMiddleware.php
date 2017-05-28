<?php

namespace LinodeApi\Middleware;

use Psr\Http\Message\RequestInterface;
use LinodeApi\Auth\AccessToken;

/**
 * Class AccessTokenMiddleware
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class AccessTokenMiddleware
{
    /** @var AccessToken */
    protected $accessToken;

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function __invoke(callable $handler)
    {
        $accessToken = (string) $this->accessToken;

        return function (RequestInterface $request, array $options) use ($handler, $accessToken) {
            $request = $request->withHeader('Authorization', $accessToken);
            return $handler($request, $options);
        };
    }
}
