<?php

namespace Pixela\Api;


interface WebhookInterface
{
    public function getGraphID();

    public function getType();

    public function getWebhookHash();
}