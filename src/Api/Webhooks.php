<?php

namespace Pixela\Api;

class Webhooks extends Api implements WebhooksInterface
{
    /**
     * @var string
     */
    protected $graphID;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $webhookHash;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/webhooks';

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            ),
            'body' => json_encode(
                array(
                    'graphID' => $this->getGraphID(),
                    'type' => $this->getType(),
                )
            )
        );

        $response = $this->getClient()->getHttpClient()->request('post', $uri, $options);
        $contents = json_decode($response->getBody()->getContents(), true);

        $this->setWebhookHash($contents['webhookHash']);

        return true;
    }

    /**
     * @return \Pixela\Api\WebhooksInterface[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/webhooks';

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            )
        );

        $response = $this->getClient()->getHttpClient()->request('get', $uri, $options);
        $contents = json_decode($response->getBody()->getContents(), true);

        return array_map(function ($data) {
            $webhook = new \Pixela\Api\Webhooks($this->getClient());
            return $webhook->setGraphID($data['graphID'])
                ->setType($data['type'])
                ->setWebhookHash($data['webhookHash']);
        }, $contents['webhooks']);
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function invoke()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/webhooks/' . $this->getWebhookHash();

        $options = array(
            'headers' => array(
                'Content-Length' => 0
            ),
        );

        return (bool)$this->getClient()->getHttpClient()->request('post', $uri, $options);
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/webhooks/' . $this->getWebhookHash();

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            )
        );

        return (bool)$this->getClient()->getHttpClient()->request('delete', $uri, $options);
    }

    /**
     * @return string
     */
    public function getGraphID()
    {
        return $this->graphID;
    }

    /**
     * @param string $graphID
     * @return $this
     */
    public function setGraphID($graphID)
    {
        $this->graphID = $graphID;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebhookHash()
    {
        return $this->webhookHash;
    }

    /**
     * @param string $hash
     * @return $this
     */
    public function setWebhookHash($hash)
    {
        $this->webhookHash = $hash;

        return $this;
    }
}
