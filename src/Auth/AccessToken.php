<?php

namespace LinodeApi\Auth;

/**
 * Class AccessToken
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class AccessToken
{
    /** @var string */
    protected $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function __toString()
    {
        return sprintf("token %s", $this->getToken());
    }
}
