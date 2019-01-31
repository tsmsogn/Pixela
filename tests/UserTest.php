<?php

namespace Pixela\Test;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pixela\Client;

class UserTest extends PixelaTestCase
{
    /**
     * @return void
     * @throws \ReflectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCRUD()
    {
        $client = new Client(self::USERNAME, self::TOKEN);
        /** @var \Pixela\Api\User $user */
        $user = $client->api('User');

        $created = $user->create();
        $this->assertTrue($created);

        $updated = $user->update('thisisnewsecret');
        $this->assertTrue($updated);
        $this->assertEquals('thisisnewsecret', $user->getClient()->getToken());

        $deleted = $user->delete();
        $this->assertTrue($deleted);
    }

    /**
     * @return void
     * @throws \ReflectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUpdateFailed()
    {
        $mock = new MockHandler([
            new Response(400),
        ]);
        $handler = HandlerStack::create($mock);
        $httpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $client = new Client(self::USERNAME, self::TOKEN, $httpClient);
        /** @var \Pixela\Api\User $user */
        $user = $client->api('User');

        try {
            $user->update('thisisnewsecret');
        } catch (\Exception $e) {
        }

        $this->assertEquals(self::TOKEN, $user->getClient()->getToken());
    }
}
