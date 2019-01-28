<?php

namespace Pixela\Api;

class Graphs extends Api implements GraphInterface
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $unit;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $timezone = 'UTC';

    /**
     * @var array
     */
    public $purgeCacheURLs;

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs';

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            ),
            'body' => json_encode(
                array(
                    'id' => $this->getId(),
                    'name' => $this->getName(),
                    'unit' => $this->getUnit(),
                    'type' => $this->getType(),
                    'color' => $this->getColor(),
                    'timezone' => $this->getTimezone()
                )
            ),
        );

        $response = $this->getClient()->getHttpClient()->request('post', $uri, $options);

        return true;
    }

    /**
     * @return \Pixela\Api\GraphInterface[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/';

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            ),
        );

        $response = $this->getClient()->getHttpClient()->request('get', $uri, $options);
        $contents = json_decode($response->getBody()->getContents(), true);

        return array_map(function ($data) {
            $graph = new \Pixela\Api\Graphs($this->getClient());

            $graph->setId($data['id'])
                ->setName($data['name'])
                ->setUnit($data['unit'])
                ->setType($data['type'])
                ->setColor($data['color'])
                ->setTimezone($data['timezone'])
                ->setPurgeCacheURLs($data['purgeCacheURLs']);

            return $graph;
        }, $contents['graphs']);
    }

    /**
     * @param \DateTimeInterface|null $dateTime
     * @param null $mode
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSVG(\DateTimeInterface $dateTime = null, $mode = null)
    {
        $params = array();
        if ($dateTime !== null) {
            $params['date'] = $dateTime->format('Ymd');
        }
        if ($mode !== null) {
            $params['mode'] = $mode;
        }

        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getId();

        if ($params) {
            $uri .= '?' . \GuzzleHttp\Psr7\build_query($params);
        }

        $options = array();

        $response = $this->getClient()->getHttpClient()->request('get', $uri, $options);

        return $response->getBody()->getContents();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getId();

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken(),
            ),
            'body' => json_encode(array(
                'name' => $this->getName(),
                'unit' => $this->getUnit(),
                'color' => $this->getColor(),
                'timezone' => $this->getTimezone(),
                'purgeCacheURLs' => $this->getPurgeCacheURLs()
            ))
        );

        $response = $this->getClient()->getHttpClient()->request('put', $uri, $options);

        return true;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername() . '/graphs/' . $this->getId();

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            ),
        );

        $response = $this->getClient()->getHttpClient()->request('delete', $uri, $options);

        return true;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return sprintf(Api::API_BASE_ENDPOINT . '/users/%s/graphs/%s.html',
            $this->getClient()->getUsername(), $this->getId());
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

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
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return array
     */
    public function getPurgeCacheURLs()
    {
        return $this->purgeCacheURLs;
    }

    /**
     * @param array $purgeCacheURLs
     */
    public function setPurgeCacheURLs($purgeCacheURLs = array())
    {
        $this->purgeCacheURLs = $purgeCacheURLs;
    }
}