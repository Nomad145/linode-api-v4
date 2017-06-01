<?php

namespace LinodeApi\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class PaginationMiddleware
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class PaginateMiddleware
{
    /** @var int */
    protected $page;

    public function __construct(int $page)
    {
        $this->page = $page;
    }

    public function __invoke(callable $handler)
    {
        $page = $this->page;

        return function (RequestInterface $request, array $options) use ($handler, $page) {
            $uri = $request->getUri()->withQuery("page=$page");
            $request = $request->withUri($uri);

            return $handler($request, $options);
        };
    }
}
