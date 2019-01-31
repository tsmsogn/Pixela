<?php

namespace Pixela\Api;

class User extends Api implements UserInterface
{
    /**
     * Create user
     *
     * @param string $agreeTermsOfService
     * @param string $notMinor
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($agreeTermsOfService = 'yes', $notMinor = 'yes')
    {
        $options = array(
            'body' => json_encode(array(
                'username' => $this->getClient()->getUsername(),
                'token' => $this->getClient()->getToken(),
                'agreeTermsOfService' => $agreeTermsOfService,
                'notMinor' => $notMinor
            )),
        );

        $response = $this->getClient()->getHttpClient()->request('post', Api::API_BASE_ENDPOINT . '/users', $options);

        return true;
    }

    /**
     * Update user
     *
     * @param $newToken
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($newToken)
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername();

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            ),
            'body' => json_encode(
                array(
                    'newToken' => $newToken
                )
            )
        );

        $response = $this->getClient()->getHttpClient()->request('put', $uri, $options);

        $this->getClient()->setToken($newToken);

        return true;
    }

    /**
     * Delete user
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete()
    {
        $uri = Api::API_BASE_ENDPOINT . '/users/' . $this->getClient()->getUsername();

        $options = array(
            'headers' => array(
                'X-USER-TOKEN' => $this->getClient()->getToken()
            )
        );

        $response = $this->getClient()->getHttpClient()->request('delete', $uri, $options);

        return true;
    }
}
