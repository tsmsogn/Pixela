<?php

namespace Pixela\Api;

abstract class Api implements ApiInterface
{
    const API_BASE_ENDPOINT = 'https://pixe.la/v1';

    /**
     * @var \Pixela\ClientInterface
     */
    public $client;

    /**
     * Client constructor.
     * @param \Pixela\ClientInterface $client
     */
    public function __construct(\Pixela\ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return \Pixela\ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \Pixela\ClientInterface $client
     */
    public function setClient(\Pixela\ClientInterface $client)
    {
        $this->client = $client;
    }
}
