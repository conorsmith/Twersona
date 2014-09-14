<?php

namespace Twersona;

class ProfileMapper
{
    protected $twitter;
    protected $cache;

    public function __construct(TwitterConsumer $twitter, CacheInterface $cache)
    {
        $this->twitter = $twitter;
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
