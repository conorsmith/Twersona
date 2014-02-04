<?php

namespace Twersona;

class ProfileMapper
{
    protected $twitter;
    protected $cache;

    public function __construct($connectionSettings, CacheInterface $cache)
    {
        if ($connectionSettings instanceof TwitterAPI) {
            $this->twitter = $connectionSettings;

        } else if (is_array($connectionSettings)) {
            $this->twitter = new TwitterAPI($connectionSettings);

        } else {
            throw new \InvalidArgumentException('The parameter was not an array or an instance of TwitterAPI');
        }

        $this->cache = $cache;
    }

    public function read()
    {
        if ($this->cache->isStale()) {
            $data = $this->twitter->getProfileData();
            $this->cache->store($data);

        } else {
            $data = $this->cache->fetch();
        }

        return $data;
    }
}
