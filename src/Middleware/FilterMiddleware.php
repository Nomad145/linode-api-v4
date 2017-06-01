<?php

namespace LinodeApi\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class FilterMiddleware
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class FilterMiddleware
{
    /** @var array */
    protected $filters;

    public function __construct(array $filters)
    {
        if (!$this->filters = json_encode($filters)) {
            throw new \InvalidArgumentException('Invalid JSON supplied.');
        }
    }

    public function __invoke(callable $handler)
    {
        $filters = $this->filters;

        return function (RequestInterface $request, array $options) use ($handler, $filters) {
            $request = $request->withHeader('X-Filter', $filters);
            return $handler($request, $options);
        };
    }
}
