<?php

namespace LinodeApi\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class AbstractContentTypeMiddleware
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
abstract class AbstractContentTypeMiddleware
{
    protected $contentType;

    public function __invoke(callable $handler)
    {
        $contentType = 'application/' . $this->contentType;

        return function (RequestInterface $request, array $options) use ($handler, $contentType) {
            $request = $request->withHeader('Content-Type', $contentType);
            return $handler($request, $options);
        };
    }
}
