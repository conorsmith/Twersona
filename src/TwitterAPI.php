<?php

namespace Twersona;

use TwitterAPIExchange;

class TwitterAPI
{
    protected $connection;

    public function __construct(array $connectionSettings)
    {
        $this->connection = new TwitterAPIExchange($connectionSettings);
    }

    public function getProfileData()
    {
        $response = $this->connection
            ->buildOauth('https://api.twitter.com/1.1/account/verify_credentials.json', 'GET')
            ->performRequest();

        return json_decode($response);
    }
}
