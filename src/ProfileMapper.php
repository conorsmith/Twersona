<?php

namespace Twersona;

class ProfileMapper
{
    protected $twitter;
    protected $storer;

    public function __construct(array $connectionSettings, StorerInterface $storer = null)
    {
        $this->twitter = new TwitterAPI($connectionSettings);

        if (is_null($storer)) {
            $this->storer = new FileStorer;
        } else {
            $this->storer = $storer;
        }
    }

    public function read()
    {
        if ($this->storer->hasCachedData()) {
            $data = $this->storer->fetch();

        } else {
            $data = $this->twitter->getProfileData();
            $this->storer->store($data);
        }

        return $data;
    }
}
