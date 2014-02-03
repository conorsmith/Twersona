<?php

namespace Twersona;

class ProfileMapper
{
    protected $twitter;
    protected $storer;

    public function __construct($connectionSettings, StorerInterface $storer = null)
    {
        if ($connectionSettings instanceof TwitterAPI) {
            $this->twitter = $connectionSettings;

        } else if (is_array($connectionSettings)) {
            $this->twitter = new TwitterAPI($connectionSettings);

        } else {
            throw new \InvalidArgumentException('The parameter was not an array or an instance of TwitterAPI');
        }

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
