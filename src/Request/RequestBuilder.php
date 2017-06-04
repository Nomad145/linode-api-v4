<?php

namespace LinodeApi\Request;

use GuzzleHttp\Psr7\Request;

/**
 * Class RequestBuilder
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class RequestBuilder
{
    protected $method = 'GET';

    protected $uri = '/';

    protected $body;

    protected $headers = [];

    /**
     * Setter for method
     *
     * @param string $method
     * @return RequestBuilder
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Setter for uri
     *
     * @param string $uri
     * @return RequestBuilder
     */
    public function setUri(string $uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Setter for body
     *
     * @param string $body
     * @return RequestBuilder
     */
    public function setBody(array $body)
    {
        $this->body = json_encode($body);

        return $this;
    }

    /**
     * Setter for headers
     *
     * @param string $headers
     * @return RequestBuilder
     */
    public function addHeader(string $header, $headerBody)
    {
        $this->headers[$header] = is_array($headerBody) ? json_encode($headerBody) : $headerBody;

        return $this;
    }

    public function build()
    {
        return new Request($this->method, $this->uri, $this->headers, $this->body);
    }
}
