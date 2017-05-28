<?php

namespace LinodeApi\Middleware;

use LinodeApi\Middleware\AbstractContentTypeMiddleware;

/**
 * Class JsonContentTypeMiddleware
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class JsonContentTypeMiddleware extends AbstractContentTypeMiddleware
{
    protected $contentType = 'json';
}
