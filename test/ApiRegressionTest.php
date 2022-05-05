<?php

namespace Micx\Test;

use Lack\Subscription\Manager\RemoteSubscriptionManager;
use PHPUnit\Framework\TestCase;

class ApiRegressionTest extends TestCase
{
    const BASEURL = "http://localhost/v1/subscription";

    public function testGetSubscriptionWithoutAuth()
    {
        $ret = phore_http_request(self::BASEURL . "/sub/sub123/client/client1")->send()->getBodyJson();
        $this->assertEquals(false, isset ($ret["private"]));
        $this->assertEquals(false, isset ($ret["clients"]["client1"]["private"]));
    }

    public function testGetSubscriptionWithAuth()
    {
        $ret = phore_http_request(self::BASEURL . "/sub/sub123/client/client1")->withBasicAuth("client1", "test")->send()->getBodyJson();
        $this->assertEquals(true, isset ($ret["private"]));
        $this->assertEquals(true, isset ($ret["clients"]["client1"]["private"]));
    }


    public function testGetSubscriptionsByClientId()
    {
        $ret = phore_http_request(self::BASEURL . "/client/client1")->withBasicAuth("client1", "test")->send()->getBodyJson();
        print_r ($ret);
    }

    public function testRemoteGetSubscription()
    {
        $m = new RemoteSubscriptionManager("http://localhost/v1/subscription");
        $ret = $m->getSubscriptionById("sub123");
        print_r ($ret);
    }

    public function testRemoteGetSubscriptionAuthenticated()
    {
        $m = new RemoteSubscriptionManager("http://localhost/v1/subscription", "client1", "test");
        $ret = $m->getSubscriptionById("sub123");

        print_r ($ret);
    }

}
