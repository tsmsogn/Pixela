<?php

namespace Pixela\Api;

interface ApiInterface
{

    public function getClient();

    public function setClient(\Pixela\ClientInterface $client);
}
