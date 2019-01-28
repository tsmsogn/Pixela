<?php

namespace Pixela;

interface ClientInterface
{
    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient();

    public function setHttpClient(\GuzzleHttp\ClientInterface $client);

    public function getUsername();

    public function setUsername($username);

    public function getToken();

    public function setToken($newToken);

    public function api($name);
}