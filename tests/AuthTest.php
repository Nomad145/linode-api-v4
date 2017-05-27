<?php

namespace Nomad145\LinodeAlphaApi\Test;

use Nomad145\LinodeAlphaAPI\Auth\AccessToken;

/**
 * Class AccessTokenTest
 * @author Michael Phillips <michael.phillips@manpow.com>
 */
class AccessTokenTest extends \PHPUnit\Framework\TestCase
{
    public function testAccessToken()
    {
        $subject = new AccessToken('access_token');

        $this->assertSame('access_token', $subject->getToken());
        $this->assertSame('access_token', (string) $subject);
    }
}