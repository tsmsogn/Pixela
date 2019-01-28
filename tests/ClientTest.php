<?php

namespace Pixela\Test;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Pixela\Client;
use Pixela\Graph;
use Pixela\Test\fixtures\Dummy;

class ClientTest extends TestCase
{
    const USERNAME = 'tsmsogn-ghost';
    const TOKEN = 'thisissecret';

    /**
     * @return void
     */
    public function testConstruct()
    {
        $client = new \Pixela\Client(self::USERNAME, self::TOKEN);

        $this->assertEquals(self::USERNAME, $client->getUsername());
        $this->assertEquals(self::TOKEN, $client->getToken());
        $this->assertInstanceOf('GuzzleHttp\Client', $client->getHttpClient());
    }

    /**
     * @return void
     */
    public function testConstructWithHttpClient()
    {
        $client = new \Pixela\Client(self::USERNAME, self::TOKEN, new Dummy());

        $this->assertInstanceOf('Pixela\Test\Fixtures\Dummy', $client->getHttpClient());
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testApi()
    {
        $client = new Client(self::USERNAME, self::TOKEN);

        $this->assertInstanceOf('Pixela\Api\User', $client->api('User'));
        $this->assertInstanceOf('Pixela\Api\Graphs', $client->api('Graphs'));
        $this->assertInstanceOf('Pixela\Api\Webhooks', $client->api('Webhooks'));
        $this->assertInstanceOf('Pixela\Api\Pixel', $client->api('Pixel'));
    }
}