<?php

namespace Pixela\Api;

class Pixel extends Api implements PixelInterface
{
    /**
     * @var string
     */
    protected $graphID;

    /**
     * @var \DateTimeInterface
     */
    protected $datetime;

    /**
     * @var string
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $optionalData;

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getGraphID();

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
            ),
            'body' => json_encode(
                array(
                    'quantity' => $this->getQuantity(),
                    'date' => $this->getDateTime()->format('Ymd'),
                    'optionalData' => $this->getOptionalData()
                )
            )
        );

        $response = $this->getClient()->getHttpClient()->request('post', $uri, $options);

        return true;
    }

    /**
     * @return \Pixela\Api\PixelInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getGraphID() . '/' . $this->getDatetime()->format('Ymd');

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
            )
        );

        $response = $this->getClient()->getHttpClient()->request('get', $uri, $options);
        $contents = array_merge(
            array(
                'quantity' => null,
                'optionalData' => ''
            ),
            json_decode($response->getBody()->getContents(), true)
        );

        $pixel = new \Pixela\Api\Pixel($this->getClient());
        $pixel->setGraphID($this->getGraphID())
            ->setDatetime($this->getDatetime())
            ->setQuantity($contents['quantity'])
            ->setOptionalData($contents['optionalData']);

        return $pixel;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getGraphId() . '/' . $this->getDateTime()->format('Ymd');

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
            ),
            'body' => json_encode(
                array(
                    'quantity' => $this->getQuantity(),
                    'optionalData' => $this->getOptionalData()
                )
            )
        );

        $response = $this->getClient()->getHttpClient()->request('put', $uri, $options);

        return true;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function increment()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getGraphId() . '/increment';

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
                'Content-Length' => 0
            )
        );

        $response = $this->getClient()->getHttpClient()->request('put', $uri, $options);

        $saved = $this->get();
        $this->setQuantity($saved->getQuantity());

        return true;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function decrement()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getGraphId() . '/decrement';

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
                'Content-Length' => 0
            )
        );

        $response = $this->getClient()->getHttpClient()->request('put', $uri, $options);

        $saved = $this->get();
        $this->setQuantity($saved->getQuantity());

        return true;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getGraphID() . '/' . $this->getDateTime()->format('Ymd');

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
            )
        );

        $response = $this->getClient()->getHttpClient()->request('delete', $uri, $options);

        return true;
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
     * @return \DateTimeInterface
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTimeInterface $datetime
     * @return $this
     */
    public function setDatetime(\DateTimeInterface $datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (string)$quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getOptionalData()
    {
        return $this->optionalData;
    }

    /**
     * @param string $optionalData
     * @return $this
     */
    public function setOptionalData($optionalData)
    {
        $this->optionalData = $optionalData;

        return $this;
    }
}
