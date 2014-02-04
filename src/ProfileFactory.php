<?php

namespace Twersona;

use Twersona\Profile\FlatProfile;
use Twersona\Profile\FlatExactKeysProfile;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

class ProfileFactory
{
    protected $mapper;

    public function __construct(
        array $twitterAPISettings,
        Filesystem $filesystem = null,
        $filesystemKey = 'twitter-profile-cache',
        $cacheMaxAge = 86400
    )
    {
        if (is_null($filesystem)) {
            $filesystem = new Filesystem(new Adapter(__DIR__.'/../storage'));
        }

        $this->mapper = new ProfileMapper($twitterAPISettings, new ProfileCache($filesystem, $filesystemKey, $cacheMaxAge));
    }

    public function buildProfile()
    {
        return $this->buildFlatProfile();
    }

    public function buildFlatProfile()
    {
        return new FlatProfile($this->getProfileData());
    }

    public function buildFlatProfileWithExactKeys()
    {
        return new FlatExactKeysProfile($this->getProfileData());
    }

    protected function getProfileData()
    {
        return $this->mapper->read();
    }
}
