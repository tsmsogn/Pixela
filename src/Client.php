<?php

namespace Pixela;

use ReflectionClass;

class Client implements ClientInterface
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $token;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    public $httpClient;

    /**
     * Client constructor.
     * @param $username
     * @param $token
     * @param \GuzzleHttp\ClientInterface|null $httpClient
     */
    public function __construct($username = null, $token = null, \GuzzleHttp\ClientInterface $httpClient = null)
    {
        $this->username = $username;
        $this->token = $token;
        $this->httpClient = ($httpClient !== null) ? $httpClient : new \GuzzleHttp\Client();
    }

    /**
     * @param $name
     * @return object
     * @throws \ReflectionException
     */
    public function api($name)
    {
        $class = new ReflectionClass('Pixela\Api\\' . $name);
        return $class->newInstanceArgs(array($this));
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param \GuzzleHttp\ClientInterface $httpClient
     */
    public function setHttpClient(\GuzzleHttp\ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
