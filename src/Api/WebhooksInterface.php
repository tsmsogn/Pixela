<?php

namespace Pixela\Api;


interface WebhooksInterface
{
    public function getGraphID();

    public function getType();

    public function getWebhookHash();
}